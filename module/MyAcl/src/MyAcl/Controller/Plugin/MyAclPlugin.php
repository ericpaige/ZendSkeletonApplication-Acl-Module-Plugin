<?
namespace MyAcl\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;
    
class MyAclPlugin extends AbstractPlugin
{
    protected $sesscontainer ;

    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('zftutorial');
        }
        return $this->sesscontainer;
    }
    
    public function doAuthorization($e)
    {
        // set ACL
        $acl = new Acl();
        $acl->deny(); // on by default
        //$acl->allow(); // this will allow every route by default so then you have to explicitly deny all routes that you want to protect.		
		
		# ROLES ############################################
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('user'),  'anonymous');
        $acl->addRole(new Role('admin'), 'user');
		# end ROLES ########################################
        
		# RESOURCES ########################################
        $acl->addResource('application'); // Application module
        $acl->addResource('album'); // Album module
		# end RESOURCES ########################################
		
		################ PERMISSIONS #######################
		// $acl->allow('role', 'resource', 'controller:action');
		
        // Application -------------------------->
        $acl->allow('anonymous', 'application', 'index:index');
        $acl->allow('anonymous', 'application', 'profile:index');
       
        // Album -------------------------->
		$acl->allow('anonymous', 'album', 'album:index'); 
		$acl->allow('anonymous', 'album', 'album:add'); 
		$acl->deny('anonymous', 'album', 'album:hello'); // denies access to route: /album/hello
		$acl->allow('anonymous', 'album', 'album:view');
		$acl->allow('anonymous', 'album', 'album:edit'); // also allows: http://zf2-tutorial.com/album/edit/1
		//$acl->deny('anonymous', 'Album', 'Album:song');
		################ end PERMISSIONS #####################
		
		
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $moduleName = strtolower(substr($controllerClass, 0, strpos($controllerClass, '\\')));
        $role = (! $this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
		$routeMatch = $e->getRouteMatch();
		
        $actionName = strtolower($routeMatch->getParam('action', 'not-found'));	// get the action name	
        $controllerName = $routeMatch->getParam('controller', 'not-found');	// get the controller name	
	$controllerName = explode('\\', $controllerName);
        $controllerName = strtolower(array_pop($controllerName));
        
/*
		print '<br>$moduleName: '.$moduleName.'<br>'; 
		print '<br>$controllerClass: '.$controllerClass.'<br>'; 
		print '$controllerName: '.$controllerName.'<br>'; 
		print '$action: '.$actionName.'<br>'; */

		
		#################### Check Access ########################
        if ( ! $acl->isAllowed($role, $moduleName, $controllerName.':'.$actionName)){
            $router = $e->getRouter();
           // $url    = $router->assemble(array(), array('name' => 'Login/auth')); // assemble a login route
            $url    = $router->assemble(array(), array('name' => 'application'));
            $response = $e->getResponse();
            $response->setStatusCode(302);
            // redirect to login page or other page.
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();            
        }
		
		
		
    }
}
