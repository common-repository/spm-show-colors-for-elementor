function spmCopyToClipboard(text) {
	var input = document.createElement('input');
	input.setAttribute('value', text);
	document.body.appendChild(input);
	input.select();
	document.execCommand('copy');
	document.body.removeChild(input);
	//alert('Copied ' + text + ' to clipboard');
	showSnackbarMessage();
	
	var banner = document.getElementById('spm-sce-banner');
	var button = document.getElementById('spm-sce-button');
	banner.style.display = 'none';
	button.style.display = 'block';
}

function showSnackbarMessage() {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

jQuery(document).ready(function() {
	function spmAddBannerClickHandlers() {
		var banner = document.getElementById('spm-sce-banner');
		var button = document.getElementById('spm-sce-button');
		var closeButton = document.querySelector('.spm-sce-close-button');
		
		if (button) {
		    button.addEventListener('click', function() {
			    banner.style.display = 'block';
			    button.style.display = 'none';
		    });
		}

        if (closeButton) {
            closeButton.addEventListener('click', function() {
			    banner.style.display = 'none';
			    button.style.display = 'block';
		    });
        }
	}
	
	spmAddBannerClickHandlers();
});
