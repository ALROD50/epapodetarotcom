<style>
    .max-width {
        max-width: 500px;
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        margin-top: 10%;
        background-color: #FFF;
        box-shadow: 0 0 5px #FFF;
        text-align: center;
    }

    button {
        padding: 10px;
        border: none;
        outline: none;
        font-family: 'Segoe UI';
        font-size: 1.1em;
        transition: all .5s;
        cursor: pointer;
        border-radius: 25px;
    }

    button:hover {
        background-color: #a1c0d1;
    }

    button:active {
        background-color: #111;
    }

    .bg-green {
        background-color: #b2d1a1;
    }

    .bg-yellow {
        background-color: #d1cba1;
    }

    .bg-red {
        background-color: #d1a1a1;
    }
</style>
<div class="max-width">
	<button onclick="start();" class="bg-green">Iniciar</button>
	<button onclick="pause();" class="bg-yellow">Pausar</button>
	<button onclick="stop();" class="bg-red">Parar</button>
	<h1 id="counter">00:00:00</h1>
</div>
<script src="cron.js"></script>

<?php 
$nomeDaSala = "123x";
// $nomeDaSala = "789";
?>

<script src='https://www.tarotdehorus.com.br/area51/external_api.js' async></script>
<style>html, body, #meet { height: 800px; }</style>
<script type="text/javascript">
	window.onload = () => {
		const domain = 'meet.jit.si/someroomname#config.subject="CodigoNomeDaSala"';
		const options = {
			roomName: '<?= $nomeDaSala; ?>',
			lang: 'pt-BR',
			configOverwrite: { 
				startWithAudioMuted: false,
				startWithVideoMuted: false,
				disableDeepLinking: true,
				rejoinPageEnabled: false,
				prejoinPageEnabled: false,
				requireDisplayName: false,
				displayName: false,
				disableProfile: false,
				// meetingPasswordEnabled: false,
			},
			interfaceConfigOverwrite: { 
				SHOW_WATERMARK_FOR_GUESTS: false,
				SHOW_JITSI_WATERMARK: false,
				SHOW_BRAND_WATERMARK: false,
				HIDE_DEEP_LINKING_LOGO: true,
				SHOW_DEEP_LINKING_IMAGE: false,
				SHOW_POWERED_BY: false,
				SHOW_PROMOTIONAL_CLOSE_PAGE: false,
				DEFAULT_REMOTE_DISPLAY_NAME: 'Tarólogo',
				FILM_STRIP_MAX_HEIGHT: 2,
				TOOLBAR_BUTTONS: [ 
					'microphone', 'camera', 'videoquality', 'recording', 'tileview'
				],
			},
			parentNode: document.querySelector('#meet')
		};
		const api = new JitsiMeetExternalAPI(domain, options);
		const api = new addEventListener('videoConferenceStart', () => {
            api.executeCommand('startRecording', {
                mode: 'file',
                dropboxToken: 'sl.BLrNk-dBr8fm3By0FcJvpLdMmiRh8ux_SRXeVSP6AXRcqf5FlnMuqYlZTh3jaujV_D6ZFvgmsWymHVT1wLMG0nLdvvPN2KAu2Me7VPdg_UUMBQQRdIQytHrRb8L-6i4E2mMkHuI',
            });
        });
	}
</script>
<a href="#"><div id="logojitsi" style="background:#292929;width: 200px;height: 50px;position: relative;top: 74px;"><img src="https://www.tarotdehorus.com.br/images/Logo-Site.fw.webp" style="width: 200px;height: 50px;"/></div></a>
<div id="meet"></div>
<!-- 'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen', 'fodeviceselection', 'hangup', 'profile', 'recording', 'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand', 'videoquality', 'filmstrip', 'feedback', 'stats', 'shortcuts', 'tileview' -->