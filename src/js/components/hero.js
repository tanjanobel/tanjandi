export default class Hero {
    init() {
        const heroVideos = document.querySelectorAll('.hero__video');
        heroVideos.forEach(video => {
            video.playbackRate = 0.5;

            let playCount = 1;
            const maxPlays = 3;

            video.addEventListener('ended', () => {
                if (playCount < maxPlays) {
                    playCount++;
                    video.play();
                } else if (playCount === maxPlays) {
                    // Start the 4th run but stop after 3 seconds
                    playCount++;
                    video.play();
                    setTimeout(() => {
                        video.pause();
                    }, 800);
                }
            });
        });
    }
}
