
import { insertYouTubeScript, loadYouTubePlayer } from './youtubePlayer';
import { insertVimeoScript, handleVimeoPlayer } from './vimeoPlayer';


const videoClass = 'js-video';
const btnClass = 'js-video-btn-play';

if (document.querySelector(`.${btnClass}[data-player="youtube"]`)) insertYouTubeScript();
if (document.querySelector(`.${btnClass}[data-player="vimeo"]`)) insertVimeoScript();

document.addEventListener('click', (e) => {
	const target = e.target;

	if (target.classList.contains(btnClass)) {
		const video = target.parentNode.querySelector(`.${videoClass}`);
		const videoPlayer = video.parentNode.parentNode;
		videoPlayer.classList.remove('is-paused');
		const loadVideo = () => {
			if (!video.classList.contains('is-loaded')) {
				video.setAttribute('src', video.dataset.src);
				video.classList.add('is-loaded');
			}
		};

		video.classList.add('is-active');

		if (target.dataset.player === 'wp') {
			loadVideo();
			video.play();
		} else if (target.dataset.player === 'youtube') {
			loadYouTubePlayer(video.dataset.playerId);
		} else if (target.dataset.player === 'vimeo') {
			loadVideo();
			handleVimeoPlayer(video.dataset.playerId);
		}
	}
});
