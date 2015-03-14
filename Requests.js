



function login(user_name,pass)
{
	var log_message = document.getElementById('login_message').innerHTML='';
	
	var request = new XMLHttpRequest;
	
	var url = 
	
	if(user_name =='')
	{
		log_message.innerHTML+='Please enter a username.';
	}
	else if(pass='')
	{
		log_message.innerHTML+='Please enter a password.';
	}
	else
	{
		request.open('POST','Login_back.php',true);
		request.send('username='+user_name+'&password='+pass);
		
		
		request.onreadstatechange = function()
		{
			if(request.readyState == 4 && request.status ==200)
			{
				if(request.responseText == 0)
				{
					log_message.innerHTML+='Wrong username or password. Please try again';
				}
				else
				{
					window.location.href='Front_Page.php';
				}
			}
		}
	}
}