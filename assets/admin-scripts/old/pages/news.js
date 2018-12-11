Vue.use(SocialSharing);

Vue.component('comment', {
	template: `
		<div class="child-commenting comment-form">
			<el-form ref="comments" :model="comments">
	          <el-form-item
	            prop="comment"
	            :rules="[
	              { required: true, message: 'Хабарингизни киритинг', trigger: 'submit' }
	            ]"
	          >
	            <el-input :rows="5" v-on:keyup.enter="submitForm('comments')" type="textarea" placeholder="Написать комментарий..." v-model="comments.comment"></el-input>
	          </el-form-item>
	          <el-form-item class="comment-button">
	            <el-button class="uff-form-btn" type="primary" @click="submitForm('comments')">Юбориш</el-button>
	          </el-form-item>
	        </el-form>
        </div>
	`,
	props: {
    	message: String,
    	model: Object
  	},
  	data: function () {
  		return {
  			comments: {
  				comment: ''
  			}
  		}
  	},
	methods: {
		submitForm(formName) {
	        this.$refs[formName].validate((valid) => {
	          if (valid) {
	            //alert('submit!');
	            this.model.comment.unshift({
	            	id: Math.random()*1000,
	            	full_name: 'Test',
	            	message: this.comments.comment,
	            	votes: 0,
	            	comment: [],
	            	date_time: '27.11.2017 14:12'
	            });
	          } else {
	            console.log('error submit!!');
	            return false;
	          }
	        });
     	}     	
	}

});
Vue.component('item', {
  data: function () {
  	return {
  		isComment: false
  	}
  },
  template: `
  	<div>
	    <div v-if="model.id" class="human-comment">
	    	<div class="avatar-container">
	    		<img :src="(model.avatar)?(folder + model.avatar):'/images/no-avatar.png'" alt="" />
	    	</div>
	    	<div class="comment-text">
	    		<div class="comment-header-info">
	    			<a href="#">{{model.full_name}}</a>
	    			<span class="comment-date">{{model.date_time}}</span>
	    		</div>
	    		<div class="comment-content">
	    			{{model.message}}
	    		</div>
	    		<div class="comment-control">
    				<div class="pull-left">
    					<a class="incVote" href="#" @click.once.prevent="model.votes++"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a>
    					<span class="votes">{{ model.votes }}</span>
    					<a class="decVote" href="#" @click.once.prevent="model.votes--"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></a>
    					<a href="#" :class="{ answer: !isComment }" @click.prevent="(isComment)?(isComment = false):(isComment = true)">ответить</a>
    				</div>
    				<a href="#" class="pull-right complain">пожаловаться</a>
	    			<div class="clear-fix"></div>
	    		</div>
	    		<comment :model="model" v-if="isComment"></comment>
	    	</div>
	    </div>
	    <div class="child-comment" v-if="isChild">
	      <item
	      	:folder="folder"
	        class="item"
	        :key="item.id"
	        v-for="item in model.comment"
	        :model="item">
	      </item>
	    </div>
  	</div>
  `,
  props: {
    model: Object,
    folder: String
  },
  computed: {
    isChild: function () {
      return this.model.comment &&
        this.model.comment.length
    }
  }
})

new Vue({
	el: '#news-view',
	methods: {
		toComment() {
			window.scroll(0, document.querySelector("#comment").offsetTop);
     	}
	}
})
var comment = new Vue({
	el: '#comment',
	data: function () {
		return {
			comments: {
	          comment: ''
	        },
	        isActive: true,
	        dataComments: {
	        	comment:
		        [
		        	{
		        		id: 1,
		        		full_name: 'Вася Пупкина',
		        		date_time: '27.11.2017 09:12',
		        		message: 'Уважаемые фанаты Барселоны, читайте внимательнее. Во фразе про переиграла, к которую все заметили, речь лишь об остроте моментов, которые измерена объективно. Стиль, владение, территория – это другое.',
		        		avatar: 'img.jpg',
		        		votes: 54,
		        		comment: [
			        		{
			        			id: 2,
				        		full_name: 'Вася Пупкина',
				        		date_time: '27.11.2017 10:12',
				        		message: 'Уважаемые фанаты Барселоны, читайте внимательнее. Во фразе про переиграла, к которую все заметили, речь лишь об остроте моментов, которые измерена объективно. Стиль, владение, территория – это другое.',
				        		avatar: 'img.jpg',
				        		votes: -2,
				        		comment: [
				        			{
				        				id: 3,
						        		full_name: 'Вася Пупкина',
						        		date_time: '27.11.2017 12:12',
						        		message: 'Уважаемые фанаты Барселоны, читайте внимательнее. Во фразе про переиграла, к которую все заметили, речь лишь об остроте моментов, которые измерена объективно. Стиль, владение, территория – это другое.',
						        		votes: 6,
						        		comment: []
						        	}
				        		]
			        		},
			        		{
			        			id: 4,
				        		full_name: 'Вася Пупкина',
				        		date_time: '27.11.2017 14:12',
				        		message: 'Уважаемые фанаты Барселоны, читайте внимательнее. Во фразе про переиграла, к которую все заметили, речь лишь об остроте моментов, которые измерена объективно. Стиль, владение, территория – это другое.',
				        		avatar: 'img.jpg',
				        		votes: 9,
				        		comment: []
			        		}
			        	],
			        },
		        	{
		        		id: 5,
		        		full_name: 'Вася Пупкина',
		        		date_time: '27.11.2017 11:15',
		        		message: 'Уважаемые фанаты Барселоны, читайте внимательнее. Во фразе про переиграла, к которую все заметили, речь лишь об остроте моментов, которые измерена объективно. Стиль, владение, территория – это другое.',
		        		votes: 54,
		        		comment: []
		        	}
		        ]
		    }
		}
	},
	methods: {
		submitForm(formName) {
	        this.$refs[formName].validate((valid) => {
	          if (valid) {
	            //alert('submit!');
	            console.log(this.$refs[formName]);
	            this.dataComments.comment.unshift({
	            	id: Math.random()*100,
	            	full_name: 'Test',
	            	message: this.comment,
	            	votes: 0,
	            	date_time: '27.11.2017 14:12'
	            });
	          } else {
	            console.log('error submit!!');
	            return false;
	          }
	        });
     	}     	
	}
})