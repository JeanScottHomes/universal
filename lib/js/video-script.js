function video() {
	var video = document.querySelector('.video_wrapper');

	if (video !== null) {
		var wrapperWidth = window.outerWidth,
			videoWidth = video.offsetWidth,
			videoHeight = video.offsetHeight;

		//this is to get around the elastic url bar on mobiles like ios... (had height added of 200px, but removed it as it was causing display issues on ios, ipad pro)
		if (wrapperWidth < 1024) {
			var wrapperHeight = window.innerHeight + 0;
		} else {
			var wrapperHeight = window.innerHeight;
		}

		var scale = Math.max(wrapperWidth / videoWidth, wrapperHeight / videoHeight);
		if (scale < 1) {
			document.querySelector('.video_wrapper').style.transform =
				'translate(-50%, -50%) ' + 'scale(1)';
		} else {
			document.querySelector('.video_wrapper').style.transform =
				'translate(-50%, -50%) ' + 'scale(' + scale + ')';
		}
	}
}

//lListen for window.resize
window.addEventListener('resize', video);

video();
