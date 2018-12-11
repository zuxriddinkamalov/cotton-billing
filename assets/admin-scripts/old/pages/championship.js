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

