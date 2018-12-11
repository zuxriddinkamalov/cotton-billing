new Vue({
  el: '#result-table',
  data: function() {
    return {
    	visible: false,
    	tour: 13,
    	gameList: [
    		{
    			team_first: {
    				name: 'Кристал Пэлас',
    				flag: 'kristal-pelas.jpg'
    			},
    			team_second: {
    				name: 'Сток Сити',
    				flag: 'stok-siti.jpg'
    			},
    			time: {
    				hour: '17:00',
    				date: '14.11.17'
    			}
    		},
    		{
    			team_first: {
    				name: 'Манчестер Юнайтед',
    				flag: 'manchester-united.jpg'
    			},
    			team_second: {
    				name: 'Брайтон-энд-Хоув Альбион',
    				flag: 'brayton-end-xouv-albion.jpg'
    			},
    			time: {
    				hour: '17:00',
    				date: '25.11.17'
    			}
    		},
    		{
    			team_first: {
    				name: 'Кристал Пэлас',
    				flag: 'kristal-pelas.jpg'
    			},
    			team_second: {
    				name: 'Сток Сити',
    				flag: 'stok-siti.jpg'
    			},
    			time: {
    				hour: '17:00',
    				date: '14.11.17'
    			}
    		},
    		{
    			team_first: {
    				name: 'Манчестер Юнайтед',
    				flag: 'manchester-united.jpg'
    			},
    			team_second: {
    				name: 'Брайтон-энд-Хоув Альбион',
    				flag: 'brayton-end-xouv-albion.jpg'
    			},
    			time: {
    				hour: '17:00',
    				date: '25.11.17'
    			}
    		},
    		{
    			team_first: {
    				name: 'Ньюкасл',
    				flag: 'kristal-pelas.jpg'
    			},
    			team_second: {
    				name: 'Уотфорд',
    				flag: 'stok-siti.jpg'
    			},
    			time: {
    				hour: '17:00',
    				date: '25.11.17'
    			}
    		},
    		{
    			team_first: {
    				name: 'Суонси Сити',
    				flag: 'sounsi-siti.jpg'
    			},
    			team_second: {
    				name: 'Борнмут',
    				flag: 'manchester-united.jpg'
    			},
    			time: {
    				hour: '17:00',
    				date: '25.11.17'
    			}
    		},
    		{
    			team_first: {
    				name: 'Ньюкасл',
    				flag: 'kristal-pelas.jpg'
    			},
    			team_second: {
    				name: 'Уотфорд',
    				flag: 'stok-siti.jpg'
    			},
    			time: {
    				hour: 0,
    				date: '25.11.17'
    			}
    		},
    		{
    			team_first: {
    				name: 'Суонси Сити',
    				flag: 'sounsi-siti.jpg'
    			},
    			team_second: {
    				name: 'Борнмут',
    				flag: 'manchester-united.jpg'
    			},
    			time: {
    				hour: '17:00',
    				date: '25.11.17'
    			}
    		}
    	]
    }
  },
  methods: {
  	tourInc: function () {
  		if (this.tour < 20 ) {
  			this.tour++
  		}
  	},
    handleClick: function () {
        return;
    },
  	tourDec: function () {
  		if (this.tour > 1 && this.tour < 21 ) {
  			this.tour--
  		}
  	},
  }
})

new Vue({
  el: '#home-news-championship',
  data: function () {
    return {
        championship_list: [
            {
                name: 'Ўзбекистон. Олий лига',
                id: 1
            },
            {
                name: 'Англия чемпионати',
                id: 2
            },
            {
                name: 'Испания чемпионати',
                id: 3
            },
            {
                name: 'Италия чемпионати',
                id: 4
            },
            {
                name: 'Германия чемпионати',
                id: 5
            },
            {
                name: 'Россия чемпионати',
                id: 6
            },
            {
                name: 'ЛЧ',
                id: 7
            },
        ],
        championship_results: [
            {
                team: 'Lokomotiv Tashkent',
                games: 30,
                wins: 22,
                defeat: 4,
                count: 70,
                flag: 'lakomotiv.jpg'
            },
            {
                team: 'Nasaf Qarshi',
                games: 30,
                wins: 20,
                defeat: 8,
                count: 62,
                flag: 'nasaf.jpg'
            },
            {
                team: 'Pakhtakor Tashkent',
                games: 30,
                wins: 18,
                defeat: 8,
                count: 59,
                flag: 'paxtakor.jpg'
            },
            {
                team: 'Bunyodkor Tashkent',
                games: 30,
                wins: 14,
                defeat: 6,
                count: 52,
                flag: 'bunyodkor.jpg'
            },
            {
                team: 'Navbahor Namangan',
                games: 30,
                wins: 12,
                defeat: 8,
                count: 46,
                flag: 'navbahor.jpg'
            },
            {
                team: 'Buxoro',
                games: 30,
                wins: 13,
                defeat: 10,
                count: 46,
                flag: 'buxoro.jpg'
            },
            {
                team: 'Mashal Muborak',
                games: 30,
                wins: 12,
                defeat: 10,
                count: 44,
                flag: 'mashal.jpg'
            },
            {
                team: 'OTMK Olmaliq',
                games: 30,
                wins: 12,
                defeat: 10,
                count: 44,
                flag: 'otmk.jpg'
            },
            {
                team: 'Kokand 1912',
                games: 30,
                wins: 11,
                defeat: 11,
                count: 41,
                flag: 'kokand.jpg'
            },
            {
                team: 'Metallurg Bekobod',
                games: 30,
                wins: 12,
                defeat: 14,
                count: 40,
                flag: 'metallurg.jpg'
            },
            {
                team: 'Qizilqum Zarafshon',
                games: 30,
                wins: 9,
                defeat: 11,
                count: 37,
                flag: 'qizilqum.jpg'
            },
            {
                team: 'Dinamo Samarkand',
                games: 30,
                wins: 8,
                defeat: 14,
                count: 32,
                flag: 'dinamo.jpg'
            },
            {
                team: 'Sogdiyona Jizzax',
                games: 30,
                wins: 8,
                defeat: 15,
                count: 31,
                flag: 'sogdiyona.jpg'
            },
            {
                team: 'Shortan Guzor',
                games: 30,
                wins: 8,
                defeat: 19,
                count: 27,
                flag: 'shortan.jpg'
            },
            {
                team: 'Neftchi Fargona',
                games: 30,
                wins: 6,
                defeat: 15,
                count: 27,
                flag: 'neftchi.jpg'
            },
            {
                team: 'Obod',
                games: 30,
                wins: 2,
                defeat: 25,
                count: 9,
                flag: 'obod.jpg'
            }
        ],
        value: 1
    }
  }
})

new Vue({
  el: '#predection',
  data: function() {
    return {
        prediction: [
            {
                name: 'umidbest8590',
                true_answers: 24,
                goal_difference: 42,
                winner_team: 92,
                all: 161
            },
            {
                name: 'Davids',
                true_answers: 30,
                goal_difference: 43,
                winner_team: 77,
                all: 150
            },
            {
                name: 'nasimbek',
                true_answers: 27,
                goal_difference: 42,
                winner_team: 79,
                all: 148
            },
            {
                name: 'fma1973',
                true_answers: 27,
                goal_difference: 43,
                winner_team: 55,
                all: 125
            },
            {
                name: 'baxritdinqi70@yahoo.com',
                true_answers: 20,
                goal_difference: 37,
                winner_team: 68,
                all: 125
            },
            {
                name: 'Autocomponent',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'fcbbarsa2',
                true_answers: 19,
                goal_difference: 35,
                winner_team: 66,
                all: 120
            },
            {
                name: 'ajm2015',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'rahmiddin_92',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Shohi',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'djtoir',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Erickbek',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Пахтакор',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Nerazzuri',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'umidbest8590',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Davids',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'nasimbek',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'fma1973',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'baxritdinqi70@yahoo.com',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Autocomponent',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'fcbbarsa2',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'ajm2015',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'rahmiddin_92',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Shohi',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'djtoir',
                true_answers: 17,
                goal_difference: 33,
                winner_team: 75,
                all: 125
            },
            {
                name: 'Erickbek',
                true_answers: 15,
                goal_difference: 32,
                winner_team: 47,
                all: 94
            },
            {
                name: 'Пахтакор',
                true_answers: 12,
                goal_difference: 27,
                winner_team: 54,
                all: 93
            },
            {
                name: 'Nerazzuri',
                true_answers: 14,
                goal_difference: 28,
                winner_team: 44,
                all: 89
            },
        ]
    }
  },
  methods: {
    handleClick: function () {
        return;
    },
  }
})