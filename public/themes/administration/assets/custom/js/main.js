/*
 *	Author:
 *		Krasimir Todorov
 *	Last editor:
 *		Krasimir Todorov
 *	Description:
 *		Loop through the classes of the element, find all col- classes and remove them
 */

function clearElementSizing(element) {
	var cl = $(element).attr("class").split(" ");
	var newClass =[];
	for(var i=0;i<cl.length;i++){
		remove = cl[i].search(/col-/);
		if(remove)newClass[newClass.length] = cl[i];
	}
	$(element).removeClass().addClass(newClass.join(" "));
}