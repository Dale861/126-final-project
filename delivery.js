window.onload = function () {
  let progress = 0;
  const progressBar = document.getElementById('progress-bar');
  const loadingText = document.getElementById('loading-text');

  const interval = setInterval(() => {
    if (progress < 80) {
      progress++;
      progressBar.style.width = progress + '%';
      loadingText.textContent = `LOADING... ${progress}%`;
    } else {
      clearInterval(interval);
      loadingText.textContent = `Almost There...`;
    }
  }, 100);
};
