$(document).ready(function() {
	$('.uff-rec-main').css('top', $('.header').height()-$(window).scrollTop())
});
$(window).scroll(function () {
	if ($(window).scrollTop()<=$('.header').height()) {
		$('.uff-rec-main').css('top', $('.header').height()-$(window).scrollTop())
	} else {
		$('.uff-rec-main').css('top', 0)
	}
});
var header = new Vue({
	el: '#header',
	data: function () {
		return {
			signInWindow: false,
			dynamicValidateForm: {
				email: '',
				pass: ''
			}
		}
	},
	methods: {
		submitForm(formName) {
	        this.$refs[formName].validate((valid) => {
	          if (valid) {
	            alert('submit!');
	          } else {
	            console.log('error submit!!');
	            return false;
	          }
	        });
     	},
	}
})