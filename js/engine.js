var app = angular.module('myApp', ['ngSanitize']);

app.filter("nl2br", ['$sce', function($sce) {
		 return function(data) {
		   if (data) {
				//var re = /,/gi
				var text
				text = data.replace(',', '');
				text = text.replace(/,,/gi, '</br>');
				text = text.replace(/,/gi, '</br>');
				return $sce.trustAsHtml(text);
			}
		 };
}]);

function TodoCtrl($scope,$http) {
  var _baseUrl = 'http://monitoring01.oovoo.local/cpanel/search.php?';
  var _url = _baseUrl;
  var _serverHost;
  var _urlCommands;
  var _serverCommands;
  var _commandRtrn;
  $scope.getServerList = function(){
	$http.get('http://monitoring01.oovoo.local/cpanel/search.php?server='+$scope.query).success(function(data, status, headers, config) { 
			$scope.serversList = data;
			if (headers('Content-Type') == 'application/json') {
				$scope.serversList = data;
			} else {
				window.location = 'http://monitoring01.oovoo.local/cpanel/index.php'
			}
	}); 
  };
  
  $scope.getServerCommands = function(elValue){  
	_serverHost = elValue; 
	_commandRtrn =null;
	_urlCommands =_url +'server='+ elValue +'&function=list'; 
	console.log(_urlCommands);
	$http.get(_urlCommands). 
		success(function(data, status, headers, config){   
			if (headers('Content-Type') == 'application/json') {
				_serverCommands=data; 
			} else {
				window.location = 'http://monitoring01.oovoo.local/cpanel/index.php'
			}
		}
	);  
  };
  
  $scope.getRunningServer=function(){
		return _serverHost;
  };
 
  $scope.getCommandsList = function(){
	return _serverCommands;
  }
  
	$scope.commandRtrn = function(){ 
		return _commandRtrn;
	}
			
  $scope.commandSend = function(cmdText){   
	console.log(_url);
	//debugger;
	_urlCommands =_url+'server='+ _serverHost + '&function=execute'; 
	console.log('commandSend:'+ _urlCommands);
	$http.get(_urlCommands)
	.success(function(data, status, headers, config){  
		if (headers('Content-Type') == 'application/json') {
			var srvExecuter = data; 
			_urlCommands = data.url+'server='+_serverHost+'&command='+cmdText ;
			console.log(_urlCommands); 
		} else {
			window.location = 'http://monitoring01.oovoo.local/cpanel/index.php'
		}
		$http.get(_urlCommands)
		.success(function(data, status, headers, config){   
			console.log(data.output);
			if (headers('Content-Type') == 'application/json') {
				_commandRtrn=data;
 			} else {
				window.location = 'http://monitoring01.oovoo.local/cpanel/index.php'
			}
		}); 	
	}); 
  };
   
}