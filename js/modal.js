(function () {
	window.onload = function() {
		if (typeof window.Gripeless === 'undefined') {
			document.getElementById('wp-admin-bar-penguinet-gripeless-report').style.display = 'none';
		}
		document.querySelector('#wp-admin-bar-penguinet-gripeless-report>a').addEventListener('click', penguinet_gripeless_open_modal);
	}

	function penguinet_gripeless_open_modal() {
		window.Gripeless.modal(PenguinetGripelessModal.projectName, {
			email: PenguinetGripelessModal.userEmail
		})
	}
})();
