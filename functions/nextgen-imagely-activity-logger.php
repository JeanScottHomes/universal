<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!class_exists('TJS_NextGenImagelyLogger')) {
  class TJS_NextGenImagelyLogger
  {
    private $startTime = 0.0;
    private $startUsage = null;
    private $logPath = '';
    private $active = false;

    public function __construct()
    {
      $this->startTime = isset($_SERVER['REQUEST_TIME_FLOAT']) ? (float) $_SERVER['REQUEST_TIME_FLOAT'] : microtime(true);
      $this->startUsage = function_exists('getrusage') ? getrusage() : null;
      $this->active = $this->isLocalContext();
      if (!$this->active) {
        return;
      }

      $this->logPath = $this->resolveLogPath();
      if ($this->logPath === '') {
        $this->active = false;
        return;
      }

      add_action('shutdown', array($this, 'maybeLogRequest'), 999);
    }

    private function isLocalContext()
    {
      if (defined('WP_LOCAL_DEV') && WP_LOCAL_DEV) {
        return true;
      }

      $host = isset($_SERVER['HTTP_HOST']) ? strtolower((string) $_SERVER['HTTP_HOST']) : '';
      if ($host !== '' && (strpos($host, '.local') !== false || $host === 'localhost')) {
        return true;
      }

      if (function_exists('home_url')) {
        $home = strtolower((string) home_url());
        if (strpos($home, '.local') !== false || strpos($home, 'localhost') !== false) {
          return true;
        }
      }

      return false;
    }

    private function resolveLogPath()
    {
      $base = '/Users/tjscott/jeanscotthomes-com/tjs-files/local-performance-logs';
      if (!is_dir($base) && function_exists('wp_mkdir_p')) {
        wp_mkdir_p($base);
      }

      if (!is_dir($base) || !is_writable($base)) {
        return '';
      }

      return trailingslashit($base) . 'nextgen-imagely-local.log';
    }

    public function maybeLogRequest()
    {
      if (!$this->active) {
        return;
      }

      $matches = array();
      if (!$this->shouldCapture($matches)) {
        return;
      }

      $now = microtime(true);
      $durationMs = ($now - $this->startTime) * 1000.0;
      $peakMemoryMb = memory_get_peak_usage(true) / 1048576.0;
      $cpu = $this->computeCpuUsage();

      $entry = array(
        'time_iso8601'      => gmdate('c'),
        'duration_ms'       => round($durationMs, 3),
        'memory_peak_mb'    => round($peakMemoryMb, 3),
        'user_cpu_ms'       => $cpu['user'],
        'system_cpu_ms'     => $cpu['system'],
        'method'            => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'CLI',
        'uri'               => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
        'script'            => isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '',
        'ajax_action'       => isset($_REQUEST['action']) ? $_REQUEST['action'] : '',
        'page'              => isset($_REQUEST['page']) ? $_REQUEST['page'] : '',
        'matched'           => array_values(array_unique($matches)),
        'user_login'        => $this->getUserLogin(),
        'process_id'        => function_exists('getmypid') ? getmypid() : null,
        'php_sapi'          => PHP_SAPI,
      );

      $this->writeLog($entry);
    }

    private function shouldCapture(array &$matches)
    {
      $tokens = array('ngg', 'nextgen', 'imagely', 'imagify', 'photocrati');
      $sources = array(
        'request_uri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
        'ajax_action' => isset($_REQUEST['action']) ? $_REQUEST['action'] : '',
        'page'        => isset($_REQUEST['page']) ? $_REQUEST['page'] : '',
        'controller'  => isset($_REQUEST['controller']) ? $_REQUEST['controller'] : '',
        'referrer'    => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
        'script'      => isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '',
      );

      foreach ($sources as $label => $value) {
        if ($value === '') {
          continue;
        }

        foreach ($tokens as $token) {
          if (stripos($value, $token) !== false) {
            $matches[] = $label . ':' . $token;
          }
        }
      }

      if (empty($matches)) {
        $included = get_included_files();
        foreach ($included as $file) {
          foreach ($tokens as $token) {
            if (stripos($file, $token) !== false) {
              $matches[] = 'include:' . $token;
              break;
            }
          }
        }
      }

      return !empty($matches);
    }

    private function computeCpuUsage()
    {
      if ($this->startUsage === null || !function_exists('getrusage')) {
        return array('user' => null, 'system' => null);
      }

      $end = getrusage();
      return array(
        'user'   => $this->usageDiffMs($this->startUsage, $end, 'ru_utime'),
        'system' => $this->usageDiffMs($this->startUsage, $end, 'ru_stime'),
      );
    }

    private function usageDiffMs($start, $end, $key)
    {
      $secKey = $key . '.tv_sec';
      $usecKey = $key . '.tv_usec';
      if (!isset($start[$secKey], $start[$usecKey], $end[$secKey], $end[$usecKey])) {
        return null;
      }

      $sec = ($end[$secKey] - $start[$secKey]) * 1000.0;
      $usec = ($end[$usecKey] - $start[$usecKey]) / 1000.0;

      return round($sec + $usec, 3);
    }

    private function getUserLogin()
    {
      if (!function_exists('wp_get_current_user')) {
        return null;
      }

      $user = wp_get_current_user();
      if (!$user || !($user instanceof WP_User)) {
        return null;
      }

      return $user->exists() ? $user->user_login : null;
    }

    private function writeLog(array $entry)
    {
      if ($this->logPath === '') {
        return;
      }

      // Logging disabled: keeping the local log file from being regenerated.
      return;

      $line = wp_json_encode($entry, JSON_UNESCAPED_SLASHES);
      if ($line === false) {
        return;
      }

      file_put_contents($this->logPath, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
  }

  // Instantiate immediately so we capture the whole request lifecycle.
  new TJS_NextGenImagelyLogger();
}
