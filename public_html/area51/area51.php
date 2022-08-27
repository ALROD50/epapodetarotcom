<?php 
$nomeDaSala = "23455";
// $nomeDaSala = "789";
?>
<script src='https://meet.jit.si/external_api.js'></script>
<style>html, body, #meet { height: 800px;}</style>
<script type="text/javascript">
	window.onload = () => {
		// const domain = 'meet.jit.si/someroomname#config.subject="CodigoNomeDaSala"';
		const domain = 'meet.jit.si';
		const options = {
			roomName: '<?= $nomeDaSala; ?>',
			lang: 'pt-BR',
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
<div id="meet"></div>