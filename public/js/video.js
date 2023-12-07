document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    let recorder;
    let stream;
    const videoElement = document.getElementById('recorder');
    const playbackElement = document.getElementById('playback');
    const startRecordButton = document.getElementById('startRecord');
    const stopRecordButton = document.getElementById('stopRecord');
    const playButton = document.getElementById('play');
    const pauseButton = document.getElementById('pause');
    const form = document.getElementById('freelancer_profile');
    const chunks = [];
    const MAX_RECORDING_TIME = 30000; // 30 seconds in milliseconds

    // Check if MediaRecorder is supported
    if (typeof MediaRecorder === 'undefined') {
        console.error('MediaRecorder is not supported in this browser.');
        return;
    }

    startRecordButton.onclick = () => {
        // Clear previous chunks
        chunks.length = 0;

        if (!recorder || recorder.state === 'inactive') {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then((_stream) => {
                    stream = _stream;
                    videoElement.srcObject = stream;
                    videoElement.style.display = 'block';
                    playbackElement.style.display = 'none';

                    recorder = new MediaRecorder(stream);

                    recorder.ondataavailable = (e) => {
                        if (e.data.size > 0) {
                            chunks.push(e.data);
                        }
                    };

                    recorder.onstart = () => {
                        console.log('Recording started');
                        // Show the "Stop Recording" button when recording starts
                        stopRecordButton.style.display = 'inline-block';

                        // Automatically stop recording after the specified duration
                        setTimeout(() => {
                            if (recorder && recorder.state === 'recording') {
                                recorder.stop();
                            }
                        }, MAX_RECORDING_TIME);
                    };

                    recorder.onstop = () => {
                        console.log('Recording stopped');
                        // Stop the video stream
                        if (stream) {
                            const tracks = stream.getTracks();
                            tracks.forEach(track => track.stop());
                        }

                        // Enable playback controls after recording stops
                        playButton.removeAttribute('disabled');
                        pauseButton.removeAttribute('disabled');
                        stopRecordButton.style.display = 'none';
                        videoElement.style.display = 'none';
                        playbackElement.style.display = 'block';

                        // Start playback automatically
                        playButton.click();
                    };

                    recorder.start();
                })
                .catch((error) => console.error('Error accessing camera:', error));
        } else {
            // If recorder is active, stop it
            recorder.stop();
        }
    };

    stopRecordButton.onclick = () => {
        // Stop the recorder if it's active
        if (recorder && recorder.state === 'recording') {

            recorder.stop();
        } else {
            console.warn('MediaRecorder is not in the recording state.');
        }
    };

    playButton.onclick = () => {
        if (chunks.length > 0) {
            const recordedBlob = new Blob(chunks, { type: 'video/webm' });
            const recordedUrl = URL.createObjectURL(recordedBlob);
            playbackElement.src = recordedUrl;
            playbackElement.play();
        }
    };

    pauseButton.onclick = () => {
        playbackElement.pause();
    };

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const blob = new Blob(chunks, { type: 'video/webm' });

        formData.append('video_upload', blob);

        // Use fetch or AJAX to send formData to your Laravel backend
        fetch('/freelancer/store-profile-settings', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => console.log('Form submitted:', data))
            .catch(error => console.error('Error submitting form:', error));
    });
});