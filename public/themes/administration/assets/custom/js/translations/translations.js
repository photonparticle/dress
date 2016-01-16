/*
 *	Author:
 *		Krasimir Todorov
 *	Last editor:
 *		Krasimir Todorov
 *	Description:
 *		Provides array with translations between english and bulgarian languages,
 *		this array here is just storage place, the translate function is located in global.js file
 */

/* Translations provider */

/*
 *	Author:
 *		Krasimir Todorov
 *	Last editor:
 *		Krasimir Todorov
 *	Description:
 *		Provides multi language support in javascript
 */

function translate(key) {
	if(translateData[key] && translateData[key].length > 0) {
		return translateData[key];
	} else {
		return key;
	}
}