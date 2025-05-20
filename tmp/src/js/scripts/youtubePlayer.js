function insertYouTubeScript() {
	if (document.querySelector('#youtubePlayerScript')) return;

	const script = document.createElement('script');
	script.id = 'youtubePlayerScript';
	script.src = 'https://www.youtube.com/iframe_api';
	document.head.appendChild(script);
}

function loadYouTubePlayer(id, pauseBtnClass = null) {
	// Add an event listener to check if the script has loaded successfully
	let player;
	const onPlayerReady = (event) => {
		player.playVideo();
	};

	// eslint-disable-next-line
    player = new YT.Player(`youtubePlayer-${id}`, {
		height: '360',
		width: '1040',
		videoId: id,
		events: {
			onReady: onPlayerReady,
		},
	});

	document.addEventListener('click', (e) => {
		const target = e.target;

		if (pauseBtnClass !== null && target.classList.contains(pauseBtnClass)) {
			player.pauseVideo();
		}
	});
}

export {insertYouTubeScript, loadYouTubePlayer};
