
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
			//console.log('made it here'); for testing
			if(request.readyState == 4 && request.status == 200)
			{
				alert(request.responseText);
				if(request.responseText == 0)
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
				if(request.responseText == 0)
				{
					log_message.innerHTML+='Error, user name already exists';
				}
				else
				{
					log_message.innerHTML+='Account creation succesfull, please log in';
					//window.location.href='Front_Page.php';
				}
			}
		}
		
		var data = 'username='+user_name+'&password='+pass_entered;
		
		request.open('POST','SignUp_back.php',true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		request.send(data);
	}
};