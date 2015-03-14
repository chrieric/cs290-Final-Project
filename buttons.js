

function deleteButton(table_name,row_id)
{
	var frm = document.createElement('form');
	frm.setAttribute('method','post');
	frm.setAttribute('action','Query_Functions.php');
	
	var hid = document.createElement('input');
	hid.type = 'hidden';
	hid.value = row_id;
	
	//this would allow me to just pass the $_POST to my deleteRow php function
	var hid2 = document.createElement('input');
	hid2.type = 'hidden';
	hid2.value = table_name;
	
	var sub = document.createElement('input');
	sub.type = 'sumbit';
	sub.name = 'deleteRow';
	sub.value = 'Delete';
 
	frm.appendChild(hid);
	frm.appendChild(hid2);
	frm.appendChild(sub);
	
	//returns button object
	return frm;
};

function updateButton(table_name,row_id)
{
	var frm = document.createElement('form');
	frm.setAttribute('method','post');
	frm.setAttribute('action','UpdateRow.php');
	
	var hid = document.createElement('input');
	hid.type = 'hidden';
	hid.value = row_id;
	//this would allow me to just pass the $_POST to my deleteRow php function
	var hid2 = document.createElement('input');
	hid2.type = 'hidden';
	hid2.value = table_name;
	var sub = document.createElement('input');
	sub.type = 'sumbit';
	sub.name = 'updateRow';
	sub.value = 'Update';
 
	frm.appendChild(hid);
	frm.appendChild(hid2);
	frm.appendChild(sub);
	//returns button object
	return frm;
};