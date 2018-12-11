/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by OSG TEAM (bigjoss@mail.ru). */
( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}( function( datepicker ) {

datepicker.regional.uz = {
	closeText: "Yopish",
	prevText: "&#x3C;Old",
	nextText: "Key&#x3E;",
	currentText: "Bugun",
	monthNames: [ "Yanvar","Fevral","Mart","Aprel","May","Iyun",
	"Iyul","Avgust","Sentyabr","Oktyabr","Noyabr","Dekabr" ],
	monthNamesShort: [ "Yan","Fev","Mar","Apr","May","Iyn",
	"Iyl","Avg","Sen","Okt","Noy","Dek" ],
	dayNames: [ "yakshanba","dushanba","seshanba","chorshanba","payshanba","juma","shanba" ],
	dayNamesShort: [ "yak","dus","ses","cho","pay","jum","sha" ],
	dayNamesMin: [ "Ya","Du","Se","Ch","Pa","Ju","Sh" ],
	weekHeader: "Haf",
	dateFormat: "dd.mm.yy",
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
datepicker.setDefaults( datepicker.regional.uz );

return datepicker.regional.uz;

} ) );
