
function login(user_name,pass_entered)
{
	var log_message = document.getElementById('login_message');
	var request;
	
	log_message.innerHTML='';
	
	if(user_name =='')
	{
		log_message.innerHTML+='Please enter a username.<br>';
	}
	else if(pass_entered=='')
	{
		log_message.innerHTML+='Please enter a password.<br>';
	}
	else if (user_name!='' && pass_entered!='')
	{	
		request = new XMLHttpRequest();
		
		request.onreadystatechange = function()
		{
			if(request.readyState == 4 && request.status == 200)
			{
				console.log(request.responseText);
				if(!request.responseText)
				{
					log_message.innerHTML+='Wrong username or password. Please try again';
				}
				else if(request.responseText == 1)
				{
					console.log('Log in Success');
					window.location.href='Front_Page.php';
				}
			}
		}
		
		var data = 'username='+user_name+'&password='+pass_entered;
		
		request.open('POST','Login_back.php',true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(data);
	}
};


function signUp(user_name,pass_entered,pass_entered2)
{
	var log_message = document.getElementById('login_message2');
	var request;
	
	log_message.innerHTML='';
	
	if(user_name =='')
	{
		log_message.innerHTML+='Please enter a username.<br>';
	}
	else if(pass_entered=='')
	{
		log_message.innerHTML+='Please enter a password.<br>';
	}
	else if(pass_entered != pass_entered2)
	{
		log_message.innerHTML+='Password fields do not match<br>';
	}
	else if (user_name!='' && pass_entered!='')
	{	
		request = new XMLHttpRequest();
		
		request.onreadystatechange = function()
		{
			//console.log('made it here'); for testing
			if(request.readyState == 4 && request.status == 200)
			{
				//console.log('made it here 2');
				if(!request.responseText)
				{
					log_message.innerHTML+='Error, user name already exists';
				}
				else if(request.responseText == 1)
				{
					log_message.innerHTML+='Account creation succesfull, please log in';
				}
			}
		}
		
		var data = 'username='+user_name+'&password='+pass_entered;
		
		request.open('POST','SignUp_back.php',true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(data);
	}
};

//can't seem to get this working properly, mainly because i can't
//figure out how to create the button dynamically in php, currently all of my ids are null
function deleteRequest(id,table,user_id)
{
	var log_message = document.getElementById('delete_message');
	var request;
	console.log('id:'+id);
	log_message.innerHTML='';
	
	if(id ='')
	{
		log_message.innerHTML+='Error, no id found<br>';
	}
	else if(table='')
	{
		log_message.innerHTML+='Error,no table found<br>';
	}
	else if(user_id='')
	{
		log_message.innerHTML+='Error, no user found<br>';
	}
	else if(id !='' && table != '' && user_id != '')
	{	
		request = new XMLHttpRequest();
		
		request.onreadystatechange = function()
		{
			//console.log('made it here'); for testing
			if(request.readyState == 4 && request.status == 200)
			{
				//console.log('made it here 2');
				if(!request.responseText)
				{
					log_message.innerHTML+='Error, delete unsuccessful';
				}
				else if(request.responseText == 1)
				{
					log_message.innerHTML+='Delete success';
				}
			}
		}
		
		var data = 'id='+id+'&delete_row=Delete'+'&t_name'+table+'&user'+user_id;
		
		request.open('POST','Back_Page.php',true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(data);
	}
};
