<?php 
$nomeDaSala = "23455";
// $nomeDaSala = "789";
?>
<script src='https://www.tarotdehorus.com.br/area51/external_api.js'></script>
<style>html, body, #meet { height: 800px;}</style>
<script type="text/javascript">
	window.onload = () => {
		// const domain = 'meet.jit.si/someroomname#config.subject="CodigoNomeDaSala"';
		const domain = 'meet.jit.si';
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
				// SHOW_POWERED_BY: false,
				SHOW_PROMOTIONAL_CLOSE_PAGE: false,
				DEFAULT_REMOTE_DISPLAY_NAME: 'Tarólogo',
				FILM_STRIP_MAX_HEIGHT: 2,
				TOOLBAR_BUTTONS: [ 
					'microphone', 'camera', 'videoquality', 'tileview'
				],
			},
			parentNode: document.querySelector('#meet')
		};
		const api = new JitsiMeetExternalAPI(domain, options);
		
		// api.addEventListener('videoConferenceStart', () => {
		// 	api.executeCommand('startRecording', {
		// 		mode: 'file',
		// 		dropboxToken: 'sl.BLrNk-dBr8fm3By0FcJvpLdMmiRh8ux_SRXeVSP6AXRcqf5FlnMuqYlZTh3jaujV_D6ZFvgmsWymHVT1wLMG0nLdvvPN2KAu2Me7VPdg_UUMBQQRdIQytHrRb8L-6i4E2mMkHuI',
		// 	});
		// 	api.executeCommand('stopRecording', 
		// 		mode: string //recording mode to stop, `stream` or `file`
		// 	);
		// });
	}
</script>
<a href="https://www.tarotdehorus.com.br/minha-conta/?pg=area51/area51.php"><div id="logojitsi" style="background:#000000;width: 205px;height: 55px;position: relative;top: 74px; border-radius: 6px 6px 6px 6px;padding: 2px;"><img src="https://www.tarotdehorus.com.br/images/Logo-Site.fw.webp" style="width: 200px;height: 50px;"/></div></a>
<div id="meet"></div>
<!-- 'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen', 'fodeviceselection', 'hangup', 'profile', 'recording', 'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand', 'videoquality', 'filmstrip', 'feedback', 'stats', 'shortcuts', 'tileview' -->