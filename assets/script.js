$( document ).ready(function() {
    $(".show-password")
    .mouseup(function () {
        $(this).siblings('.password').attr('type', 'password');
    }).mouseleave(function() {
        $(this).siblings('.password').attr('type', 'password');
    }).mousedown(function () {
        $(this).siblings('.password').attr('type', 'text');
    });
});
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.filter('moment', function(value, format) {
  return moment(value).format(format)
})
ELEMENT.locale(ELEMENT.lang.ruRU)

let editStaple = Vue.extend({
  template: '#edit-staple',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      factories: [],
      currencies: [],
      loading: false,
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      filter: {
        start: '',
        end: '',
        factory_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url,
      formData: {
        factory_id: '',
        weight: '',
        summ: '',
        by_bank: '',
        by_tax: '',
        by_self_counting: '',
        currency_id: '',
        date: '',
      }
    }
  },  
  created () {
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    submitForm (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertStaple', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!')
              this.$refs[formName].resetFields()
              this.loadData()
            } else {
              this.$message.error('Bunday yozuv mavjud')
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    },
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllStaples", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          company: (this.$route.query.company)?this.$route.query.company:this.filter.factory_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.factories = response.factories
        this.currencies = response.currencies
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteStaple", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!');
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData()
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getStapleById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!')
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateStaple', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    }
  }
});

let editCorn = Vue.extend({
  template: '#edit-corn',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      factories: [],
      currencies: [],
      loading: false,
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      filter: {
        start: '',
        end: '',
        factory_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url,
      formData: {
        factory_id: '',
        weight: '',
        summ: '',
        by_bank: '',
        by_tax: '',
        by_self_counting: '',
        currency_id: '',
        date: '',
      }
    }
  },  
  created () {
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    submitForm (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertCorn', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!')
              this.$refs[formName].resetFields()
              this.loadData()
            } else {
              this.$message.error('Bunday yozuv mavjud')
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    },
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllCorns", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          company: (this.$route.query.company)?this.$route.query.company:this.filter.factory_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.factories = response.factories
        this.currencies = response.currencies
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteCorn", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!');
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData()
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getCornById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!')
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateCorn', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    }
  }
});

let editCotton = Vue.extend({
  template: '#edit-cotton',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      factories: [],
      currencies: [],
      loading: false,
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      filter: {
        start: '',
        end: '',
        factory_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url,
      formData: {
        factory_id: '',
        weight: '',
        summ: '',
        by_bank: '',
        by_tax: '',
        by_self_counting: '',
        currency_id: '',
        date: '',
      }
    }
  },  
  created () {
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    submitForm (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertCotton', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!')
              this.$refs[formName].resetFields()
              this.loadData()
            } else {
              this.$message.error('Bunday yozuv mavjud')
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    },
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllCottons", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          company: (this.$route.query.company)?this.$route.query.company:this.filter.factory_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.factories = response.factories
        this.currencies = response.currencies
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteCotton", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!');
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData()
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getCottonById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!')
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateCotton', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    }
  }
});

let editOther = Vue.extend({
  template: '#edit-other',
  data: function() {
    return {
      news: [],
      total: 0,
      offset: 1,
      base_url: base_url
    }
  },  
  created(){

  },
  methods: {
  
  }
});

let addReport = Vue.extend({
  template: '#add-report',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      currencies: [],
      charges_types: [],
      loading: false,
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      filter: {
        start: '',
        end: '',
        charges_type_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url,
      formData: {
        output_summ: '',
        currency_id: '',
        date: '',
        charges_type_id: '',
        description: ''
      }
    }
  },  
  created () {
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    submitForm (formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertCharges', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!')
              this.$refs[formName].resetFields()
              this.loadData()
            } else {
              this.$message.error('Bunday yozuv mavjud')
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    },
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllCharges", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          charges: (this.$route.query.charges)?this.$route.query.charges:this.filter.charges_type_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.currencies = response.currencies
        this.charges_types = response.charges_types
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          charges: this.filter.charges_type_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteCharges", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!');
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData()
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getChargesById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!')
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateCharges', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    }
  }
});

let statStaple = Vue.extend({
  template: '#statistics-staple',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      factories: [],
      currencies: [],
      loading: false,
      filter: {
        one_filter: false,
        start: '',
        end: '',
        factory_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url
    }
  },  
  created(){
    this.loadData()
    this.offset = this.$route.query.offset
    this.filter.factory_id = this.$route.query.company
    this.filter.one_filter = (this.$route.query.one_filter === 'true') ? true : false
    this.filter.start = this.$route.query.start
    this.filter.end = this.$route.query.end
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllStaples", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          company: (this.$route.query.company)?this.$route.query.company:this.filter.factory_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end,
          one_filter: (this.$route.query.one_filter)?this.$route.query.one_filter:this.filter.one_filter,
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.factories = response.factories
        this.currencies = response.currencies
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    }
  }
});

let statCorn = Vue.extend({
  template: '#statistics-corn',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      factories: [],
      currencies: [],
      loading: false,
      filter: {
        one_filter: false,
        start: '',
        end: '',
        factory_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url
    }
  },  
  created(){
    this.loadData()
    this.offset = this.$route.query.offset
    this.filter.factory_id = this.$route.query.company
    this.filter.one_filter = (this.$route.query.one_filter === 'true') ? true : false
    this.filter.start = this.$route.query.start
    this.filter.end = this.$route.query.end
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllCorns", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          company: (this.$route.query.company)?this.$route.query.company:this.filter.factory_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end,
          one_filter: (this.$route.query.one_filter)?this.$route.query.one_filter:this.filter.one_filter,
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.factories = response.factories
        this.currencies = response.currencies
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    }
  }
});

let statCotton = Vue.extend({
  template: '#statistics-cotton',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      factories: [],
      currencies: [],
      loading: false,
      filter: {
        one_filter: false,
        start: '',
        end: '',
        factory_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url
    }
  },  
  created(){
    this.loadData()
    this.offset = this.$route.query.offset
    this.filter.factory_id = this.$route.query.company
    this.filter.one_filter = (this.$route.query.one_filter === 'true') ? true : false
    this.filter.start = this.$route.query.start
    this.filter.end = this.$route.query.end
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllCottons", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          company: (this.$route.query.company)?this.$route.query.company:this.filter.factory_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end,
          one_filter: (this.$route.query.one_filter)?this.$route.query.one_filter:this.filter.one_filter,
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.factories = response.factories
        this.currencies = response.currencies
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    }
  }
});

let statOther = Vue.extend({
  template: '#statistics-other',
  data: function() {
    return {
      news: [],
      total: 0,
      offset: 1,
      base_url: base_url
    }
  },  
  created(){

  },
  methods: {
  
  }
});

let statCharges = Vue.extend({
  template: '#statistics-charges',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      currencies: [],
      charges_types: [],
      loading: false,
      filter: {
        one_filter: false,
        start: '',
        end: '',
        charges_type_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url
    }
  },  
  created () {
    this.loadData()
    this.offset = this.$route.query.offset
    this.filter.charges_type_id = this.$route.query.charges
    this.filter.one_filter = (this.$route.query.one_filter === 'true') ? true : false
    this.filter.start = this.$route.query.start
    this.filter.end = this.$route.query.end
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    getCurrency (id) {
      let curr = this.currencies.filter((item, index) => {
        return item.id === id
      })
      return curr[0].name
    },
    loadData () {
      this.loading = true
      this.$http.get("posts/getAllCharges", {
        params: {
          limit: (this.$route.query.limit)?this.$route.query.limit:this.limit,
          offset: (this.$route.query.offset)?this.$route.query.offset:this.offset,
          charges: (this.$route.query.charges)?this.$route.query.charges:this.filter.charges_type_id,
          start: (this.$route.query.start)?this.$route.query.start:this.filter.start,
          end: (this.$route.query.end)?this.$route.query.end:this.filter.end,
          one_filter: (this.$route.query.one_filter)?this.$route.query.one_filter:this.filter.one_filter
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.currencies = response.currencies
        this.charges_types = response.charges_types
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          one_filter: this.filter.one_filter,
          charges: this.filter.charges_type_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    }
  }
});

let optFactory = Vue.extend({
  template: '#options-factory',
  data: function() {
    return {
      post: [],
      loading: false,
      total: 0,
      offset: 1,
      limit: 100,
      filter: {
        name: ''
      },
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      base_url: base_url,
      formData: {
        name: '',
        phone: '',
        info: '',
        address: ''
      }
    }
  },  
  created(){
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1
      }
      this.loadData()
    }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertFactory/', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!')
              this.$refs[formName].resetFields()
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!')
          return false
        }
      });
    },
    loadData() {
      this.loading = true
      this.$http.get("posts/getAllFactories", {
        params: {
          limit: this.limit,
          offset: this.offset,
          name: this.filter.name
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.loading = false
      });
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          name: this.filter.name
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteFactory", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!')
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData();
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getFactoryById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!')
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateFactory/', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!')
          return false
        }
      });
    }
  }
});

let optCurrency = Vue.extend({
  template: '#options-currency',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      base_url: base_url,
      formData: {
        name: '',
        code: ''
      }
    }
  },  
  created(){
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1
      }
      this.loadData()
    }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertCurrency/', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!')
              this.$refs[formName].resetFields()
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!')
          return false;
        }
      });
    },
    loadData() {
      this.$http.get("posts/getAllCurrencies", {
        params: {
          limit: this.limit,
          offset: this.offset
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
      });
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteCurrency", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!')
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData();
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getCurrencyById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!')
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateCurrency/', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!')
          return false
        }
      });
    }
  }
});

let optCharges = Vue.extend({
  template: '#options-charges',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      base_url: base_url,
      formData: {
        name: ''
      }
    }
  },  
  created(){
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1
      }
      this.loadData()
    }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertChargesType/', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!');
              this.$refs[formName].resetFields()
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!')
          return false;
        }
      });
    },
    loadData() {
      this.$http.get("posts/getAllChargesType", {
        params: {
          limit: this.limit,
          offset: this.offset
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
      });
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteChargesType", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!')
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData()
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getChargesTypeById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateChargesType/', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    }
  }
});

let optDislocation = Vue.extend({
  template: '#options-dislocation',
  data: function() {
    return {
      post: [],
      total: 0,
      offset: 1,
      limit: 100,
      factories: [],
      loading: false,
      edit: {
        editDialogVisible: false,
        data: Object.assign({})
      },
      filter: {
        start: '',
        end: '',
        factory_id: ''
      },
      option: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      base_url: base_url,
      formData: {
        factory_id: '',
        weight: '',
        date: '',
      }
    }
  },  
  created(){
    this.loadData()
  },
  watch: {
    '$route' (to, from) {
      if (this.$route.query.offset) {
        this.offset = parseInt(this.$route.query.offset)
      } else {
        this.offset = 1;
      }
      this.loadData()
    }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.formData, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/insertDislocation', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli qo\'shildi!')
              this.$refs[formName].resetFields()
              this.loadData()
            } else {
              this.$message.error('Bunday yozuv mavjud')
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    },
    loadData() {
      this.loading = true
      this.$http.get("posts/getAllDislocations", {
        params: {
          limit: this.limit,
          offset: this.offset,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!');
      }).then(response => {
        this.total = response.count
        this.post = response.data
        this.factories = response.factories
        this.loading = false
      })
    },
    pageChange (current) {
      this.$router.push({
        name: this.$route.name,
        query: {
          offset: current,
          company: this.filter.factory_id,
          start: this.filter.start,
          end: this.filter.end
        }
      })
    },
    deletePost (id) {
      this.$confirm('Siz rostdan ham bu yozuvni o\'chirmoqchimisiz?', 'Warning', {
        confirmButtonText: 'Ha',
        cancelButtonText: 'Yo`q',
        type: 'warning'
      }).then(() => {
        this.$http.get("posts/deleteDislocation", {
          params: {
            id: id
          }
        }).then(response => {
          return response.json()
        }, response => {
          this.$message.error('Xatolik yuz berdi!');
        }).then(response => {
          if (response.success) {
            this.$message.success('Yozuv Muvoffaqqiyatli o\'chirildi!')
            this.$router.push({
              name: this.$route.name,
            });
            this.loadData()
          }
        });
      }).catch(() => {})
    },
    editPost (id) {
      this.$http.get("posts/getDislocationById", {
        params: {
          id: id
        }        
      }).then(response => {
        return response.json()
      }, response => {
        this.$message.error('Xatolik yuz berdi!')
      }).then(response => {
        this.edit.data = response.data
        this.edit.editDialogVisible = true
      });
    },
    updatePost(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let variables = Object.assign({}, this.edit.data, csrf)
          let formData = new FormData()
          for ( var key in variables ) {
            formData.append(key, variables[key])
          }
          this.$http.post('posts/updateDislocation', formData).then(response => {
            return response.json()
          }, response => console.log(response)).then(response => {
            if (response.success) {
              this.$message.success('Muvoffaqqiyatli o\'zgartirildi!')
              this.$refs[formName].resetFields()
              this.edit.data = Object.assign({})
              this.edit.editDialogVisible = false
              this.loadData()
            }
          })
        } else {
          this.$message.error('Xatolik yuz berdi!');
          return false;
        }
      });
    }
  }
});

const routes = new VueRouter({
	routes: [
    {
      path: '',
      name: 'editStaple',
      component: editStaple
    },
    {
      path: '/edit-corn',
      name: 'editCorn',
      component: editCorn
    },
    {
      path: '/edit-cotton',
      name: 'editCotton',
      component: editCotton
    },
    {
      path: '/edit-other',
      name: 'editOther',
      component: editOther
    },
    {
      path: '/add-report',
      name: 'addReport',
      component: addReport
    },
    {
      path: '/statistics-staple',
      name: 'statStaple',
      component: statStaple
    },
    {
      path: '/statistics-corn',
      name: 'statCorn',
      component: statCorn
    },
    {
      path: '/statistics-cotton',
      name: 'statCotton',
      component: statCotton
    },
    {
      path: '/statistics-other',
      name: 'statOther',
      component: statOther
    },
    {
      path: '/statistics-charges',
      name: 'statCharges',
      component: statCharges
    },
    {
      path: '/options-factory',
      name: 'optFactory',
      component: optFactory
    },
    {
      path: '/options-currency',
      name: 'optCurrency',
      component: optCurrency
    },
    {
      path: '/options-charges',
      name: 'optCharges',
      component: optCharges
    },
    {
      path: '/options-dislocation',
      name: 'optDislocation',
      component: optDislocation
    },
    {
    	path: "*",
    	redirect: '/'
    }
	]
})
Vue.http.options.root = base_url;

let app = new Vue({
	el: '#app',
	router: routes,
	data: function () {
		return {
			
		}
	}
})