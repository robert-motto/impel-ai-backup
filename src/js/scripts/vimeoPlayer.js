function insertVimeoScript() {
	if (document.querySelector('#vimeoPlayerScript')) return;

	const script = document.createElement('script');
	script.id = 'vimeoPlayerScript';
	script.src = 'https://player.vimeo.com/api/player.js';
	document.head.appendChild(script);
}

function handleVimeoPlayer(id, pauseBtnClass = null) {
	const iframe = document.querySelector(`#vimeoPlayer-${id}`);
	// eslint-disable-next-line
    const player = new Vimeo.Player(iframe);
	player.play();

	document.addEventListener('click', (e) => {
		const target = e.target;

		if (pauseBtnClass !== null && target.classList.contains(pauseBtnClass)) {
			player.pause();
		}
	});
}

export { insertVimeoScript, handleVimeoPlayer };
