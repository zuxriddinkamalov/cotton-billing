new Vue({
	el: '#contact-page',
	data: function () {
		return {
			contacts: {
	          name: '',
	          message: '',
	          email: ''
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