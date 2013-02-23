<?
namespace Album\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Session\Container as SessionContainer,
    Zend\Permissions\Acl\Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;
    
class Myplugin extends AbstractPlugin
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
        //setting ACL...
        $acl = new Acl();
        //add role ..
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('user'),  'anonymous');
        $acl->addRole(new Role('admin'), 'user');
        
        $acl->addResource(new Resource('Application'));
        $acl->addResource(new Resource('Login'));
        $acl->addResource(new Resource('Album'));
        
		/*
		###########################################
		
        //$acl->deny('anonymous', 'Application', 'view');
        $acl->allow('anonymous', 'Application', 'view');
        $acl->allow('anonymous', 'Login', 'view');
        $acl->allow('anonymous', 'Album', 'add');
        
        $acl->allow('user',
            array('Application'),
            array('view')
        );
        
        //admin is child of user, can publish, edit, and view too !
        $acl->allow('admin',
            array('Application'),
            array('publish', 'edit')
        );
        ###########################################
		*/
		
        
		###########################################
		
        //$acl->deny('anonymous', 'Application', 'view');
        $acl->deny('anonymous', 'Application', 'view');
        $acl->allow('anonymous', 'Login', 'view');
        $acl->allow('anonymous', 'Album', 'add');
        $acl->allow('anonymous', 'Album', 'view');
        

 
        ###########################################
		
		
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $namespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
        
        $role = (! $this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
		
		// testing
		//print_r($controller); print '<br>';
/*
		print_r($controllerClass); print '<br>';
		print_r($namespace); print '<br>';
		print_r($role); print '<br>';*/

		// ----
		
		
        if ( ! $acl->isAllowed($role, $namespace, 'view')){
            $router = $e->getRouter();
           // $url    = $router->assemble(array(), array('name' => 'Login/auth'));
            //$url    = $router->assemble(array(), array('name' => 'application'));
            $url    = $router->assemble(array(), array('name' => 'album'));
        
            $response = $e->getResponse();
            $response->setStatusCode(302);
            //redirect to login route...
            // change with header('location: '.$url); if code below not working 
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();            
        }
		
		
		
    }
}
