function _costume_alert(ti,ci){
	$.alert({
	  title: ti,
	  content: ci,
	  icon: 'fa fa-info-circle',
	  animation: 'scale',
	  closeAnimation: 'scale',
      type: 'blue',
      typeAnimated: true,
	  buttons: {
	      okay: {
	          text: 'OK',
	          btnClass: 'btn-blue'
	      }
	  }
	});
}

