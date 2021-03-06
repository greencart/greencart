<?php
/**
 * TestTaskTest file
 *
 * Test Case for test generation shell task
 *
 * PHP 5
 *
 * CakePHP :  Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc.
 * @link          http://cakephp.org CakePHP Project
 * @package       Cake.Test.Case.Console.Command.Task
 * @since         CakePHP v 1.2.0.7726
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('ShellDispatcher', 'Console');
App::uses('ConsoleOutput', 'Console');
App::uses('ConsoleInput', 'Console');
App::uses('Shell', 'Console');
App::uses('TestTask', 'Console/Command/Task');
App::uses('TemplateTask', 'Console/Command/Task');
App::uses('Controller', 'Controller');
App::uses('Model', 'Model');

/**
 * Test Article model
 *
 * @package       Cake.Test.Case.Console.Command.Task
 * @package       Cake.Test.Case.Console.Command.Task
 */
class TestTaskArticle extends Model {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'TestTaskArticle';

/**
 * Table name to use
 *
 * @var string
 */
	public $useTable = 'articles';

/**
 * HasMany Associations
 *
 * @var array
 */
	public $hasMany = array(
		'Comment' => array(
			'className' => 'TestTask.TestTaskComment',
			'foreignKey' => 'article_id',
		)
	);

/**
 * Has and Belongs To Many Associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'TestTaskTag',
			'joinTable' => 'articles_tags',
			'foreignKey' => 'article_id',
			'associationForeignKey' => 'tag_id'
		)
	);

/**
 * Example public method
 *
 * @return void
 */
	public function doSomething() {
	}

/**
 * Example Secondary public method
 *
 * @return void
 */
	public function doSomethingElse() {
	}

/**
 * Example protected method
 *
 * @return void
 */
	protected function _innerMethod() {
	}
}

/**
 * Tag Testing Model
 *
 * @package       Cake.Test.Case.Console.Command.Task
 * @package       Cake.Test.Case.Console.Command.Task
 */
class TestTaskTag extends Model {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'TestTaskTag';

/**
 * Table name
 *
 * @var string
 */
	public $useTable = 'tags';

/**
 * Has and Belongs To Many Associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Article' => array(
			'className' => 'TestTaskArticle',
			'joinTable' => 'articles_tags',
			'foreignKey' => 'tag_id',
			'associationForeignKey' => 'article_id'
		)
	);
}

/**
 * Simulated plugin
 *
 * @package       Cake.Test.Case.Console.Command.Task
 * @package       Cake.Test.Case.Console.Command.Task
 */
class TestTaskAppModel extends Model {
}

/**
 * Testing AppMode (TaskComment)
 *
 * @package       Cake.Test.Case.Console.Command.Task
 * @package       Cake.Test.Case.Console.Command.Task
 */
class TestTaskComment extends TestTaskAppModel {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'TestTaskComment';

/**
 * Table name
 *
 * @var string
 */
	public $useTable = 'comments';

/**
 * Belongs To Associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Article' => array(
			'className' => 'TestTaskArticle',
			'foreignKey' => 'article_id',
		)
	);
}

/**
 * Test Task Comments Controller
 *
 * @package       Cake.Test.Case.Console.Command.Task
 * @package       Cake.Test.Case.Console.Command.Task
 */
class TestTaskCommentsController extends Controller {

/**
 * Controller Name
 *
 * @var string
 */
	public $name = 'TestTaskComments';

/**
 * Models to use
 *
 * @var array
 */
	public $uses = array('TestTaskComment', 'TestTaskTag');
}

/**
 * TestTaskTest class
 *
 * @package       Cake.Test.Case.Console.Command.Task
 */
class TestTaskTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var string
 */
	public $fixtures = array('core.article', 'core.comment', 'core.articles_tag', 'core.tag');

/**
 * setup method
 *
 * @return void
 */
	public function setup() {
		parent::setup();
		$out = $this->getMock('ConsoleOutput', array(), array(), '', false);
		$in = $this->getMock('ConsoleInput', array(), array(), '', false);

		$this->Task = $this->getMock('TestTask',
			array('in', 'err', 'createFile', '_stop', 'isLoadableClass'),
			array($out, $out, $in)
		);
		$this->Task->name = 'Test';
		$this->Task->Template = new TemplateTask($out, $out, $in);
	}

/**
 * endTest method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->Task);
		CakePlugin::unload();
	}

/**
 * Test that file path generation doesn't continuously append paths.
 *
 * @return void
 */
	public function testFilePathGenerationModelRepeated() {
		$this->Task->expects($this->never())->method('err');
		$this->Task->expects($this->never())->method('_stop');

		$file = TESTS . 'Case' . DS . 'Model' . DS . 'MyClassTest.php';

		$this->Task->expects($this->at(1))->method('createFile')
			->with($file, new PHPUnit_Framework_Constraint_IsAnything());

		$this->Task->expects($this->at(3))->method('createFile')
			->with($file, new PHPUnit_Framework_Constraint_IsAnything());

		$file = TESTS . 'Case' . DS . 'Controller' . DS . 'CommentsControllerTest.php';
		$this->Task->expects($this->at(5))->method('createFile')
			->with($file, new PHPUnit_Framework_Constraint_IsAnything());

		$this->Task->bake('Model', 'MyClass');
		$this->Task->bake('Model', 'MyClass');
		$this->Task->bake('Controller', 'Comments');
	}

/**
 * Test that method introspection pulls all relevant non parent class
 * methods into the test case.
 *
 * @return void
 */
	public function testMethodIntrospection() {
		$result = $this->Task->getTestableMethods('TestTaskArticle');
		$expected = array('dosomething', 'dosomethingelse');
		$this->assertEqual(array_map('strtolower', $result), $expected);
	}

/**
 * test that the generation of fixtures works correctly.
 *
 * @return void
 */
	public function testFixtureArrayGenerationFromModel() {
		$subject = ClassRegistry::init('TestTaskArticle');
		$result = $this->Task->generateFixtureList($subject);
		$expected = array('plugin.test_task.test_task_comment', 'app.articles_tags',
			'app.test_task_article', 'app.test_task_tag');

		$this->assertEqual(sort($result), sort($expected));
	}

/**
 * test that the generation of fixtures works correctly.
 *
 * @return void
 */
	public function testFixtureArrayGenerationFromController() {
		$subject = new TestTaskCommentsController();
		$result = $this->Task->generateFixtureList($subject);
		$expected = array('plugin.test_task.test_task_comment', 'app.articles_tags',
			'app.test_task_article', 'app.test_task_tag');

		$this->assertEqual(sort($result), sort($expected));
	}

/**
 * test user interaction to get object type
 *
 * @return void
 */
	public function testGetObjectType() {
		$this->Task->expects($this->once())->method('_stop');
		$this->Task->expects($this->at(0))->method('in')->will($this->returnValue('q'));
		$this->Task->expects($this->at(2))->method('in')->will($this->returnValue(2));

		$this->Task->getObjectType();

		$result = $this->Task->getObjectType();
		$this->assertEqual($result, $this->Task->classTypes['Controller']);
	}

/**
 * creating test subjects should clear the registry so the registry is always fresh
 *
 * @return void
 */
	public function testRegistryClearWhenBuildingTestObjects() {
		ClassRegistry::flush();
		$model = ClassRegistry::init('TestTaskComment');
		$model->bindModel(array(
			'belongsTo' => array(
				'Random' => array(
					'className' => 'TestTaskArticle',
					'foreignKey' => 'article_id',
				)
			)
		));
		$keys = ClassRegistry::keys();
		$this->assertTrue(in_array('test_task_comment', $keys));
		$object = $this->Task->buildTestSubject('Model', 'TestTaskComment');

		$keys = ClassRegistry::keys();
		$this->assertFalse(in_array('random', $keys));
	}

/**
 * test that getClassName returns the user choice as a classname.
 *
 * @return void
 */
	public function testGetClassName() {
		$objects = App::objects('model');
		$this->skipIf(empty($objects), 'No models in app.');

		$this->Task->expects($this->at(0))->method('in')->will($this->returnValue('MyCustomClass'));
		$this->Task->expects($this->at(1))->method('in')->will($this->returnValue(1));

		$result = $this->Task->getClassName('Model');
		$this->assertEqual($result, 'MyCustomClass');

		$result = $this->Task->getClassName('Model');
		$options = App::objects('model');
		$this->assertEqual($result, $options[0]);
	}

/**
 * Test the user interaction for defining additional fixtures.
 *
 * @return void
 */
	public function testGetUserFixtures() {
		$this->Task->expects($this->at(0))->method('in')->will($this->returnValue('y'));
		$this->Task->expects($this->at(1))->method('in')
			->will($this->returnValue('app.pizza, app.topping, app.side_dish'));

		$result = $this->Task->getUserFixtures();
		$expected = array('app.pizza', 'app.topping', 'app.side_dish');
		$this->assertEqual($expected, $result);
	}

/**
 * test that resolving classnames works
 *
 * @return void
 */
	public function testGetRealClassname() {
		$result = $this->Task->getRealClassname('Model', 'Post');
		$this->assertEqual($result, 'Post');

		$result = $this->Task->getRealClassname('Controller', 'Posts');
		$this->assertEqual($result, 'PostsController');

		$result = $this->Task->getRealClassname('Helper', 'Form');
		$this->assertEqual($result, 'FormHelper');

		$result = $this->Task->getRealClassname('Behavior', 'Containable');
		$this->assertEqual($result, 'ContainableBehavior');

		$result = $this->Task->getRealClassname('Component', 'Auth');
		$this->assertEqual($result, 'AuthComponent');
	}

/**
 * test baking files.  The conditionally run tests are known to fail in PHP4
 * as PHP4 classnames are all lower case, breaking the plugin path inflection.
 *
 * @return void
 */
	public function testBakeModelTest() {
		$this->Task->expects($this->once())->method('createFile')->will($this->returnValue(true));
		$this->Task->expects($this->once())->method('isLoadableClass')->will($this->returnValue(true));

		$result = $this->Task->bake('Model', 'TestTaskArticle');

		$this->assertContains("App::uses('TestTaskArticle', 'Model')", $result);
		$this->assertContains('class TestTaskArticleTestCase extends CakeTestCase', $result);

		$this->assertContains('function setUp()', $result);
		$this->assertContains("\$this->TestTaskArticle = ClassRegistry::init('TestTaskArticle')", $result);

		$this->assertContains('function tearDown()', $result);
		$this->assertContains('unset($this->TestTaskArticle)', $result);

		$this->assertContains('function testDoSomething()', $result);
		$this->assertContains('function testDoSomethingElse()', $result);

		$this->assertContains("'app.test_task_article'", $result);
		$this->assertContains("'plugin.test_task.test_task_comment'", $result);
		$this->assertContains("'app.test_task_tag'", $result);
		$this->assertContains("'app.articles_tag'", $result);
	}

/**
 * test baking controller test files, ensure that the stub class is generated.
 * Conditional assertion is known to fail on PHP4 as classnames are all lower case
 * causing issues with inflection of path name from classname.
 *
 * @return void
 */
	public function testBakeControllerTest() {
		$this->Task->expects($this->once())->method('createFile')->will($this->returnValue(true));
		$this->Task->expects($this->once())->method('isLoadableClass')->will($this->returnValue(true));

		$result = $this->Task->bake('Controller', 'TestTaskComments');

		$this->assertContains("App::uses('TestTaskCommentsController', 'Controller')", $result);
		$this->assertContains('class TestTaskCommentsControllerTestCase extends CakeTestCase', $result);

		$this->assertContains('class TestTestTaskCommentsController extends TestTaskCommentsController', $result);
		$this->assertContains('public $autoRender = false', $result);
		$this->assertContains('function redirect($url, $status = null, $exit = true)', $result);

		$this->assertContains('function setUp()', $result);
		$this->assertContains("\$this->TestTaskComments = new TestTestTaskCommentsController()", $result);
		$this->assertContains("\$this->TestTaskComments->constructClasses()", $result);

		$this->assertContains('function tearDown()', $result);
		$this->assertContains('unset($this->TestTaskComments)', $result);

		$this->assertContains("'app.test_task_article'", $result);
		$this->assertContains("'plugin.test_task.test_task_comment'", $result);
		$this->assertContains("'app.test_task_tag'", $result);
		$this->assertContains("'app.articles_tag'", $result);
	}

/**
 * test Constructor generation ensure that constructClasses is called for controllers
 *
 * @return void
 */
	public function testGenerateConstructor() {
		$result = $this->Task->generateConstructor('controller', 'PostsController');
		$expected = "new TestPostsController();\n\t\t\$this->Posts->constructClasses();\n";
		$this->assertEqual($expected, $result);

		$result = $this->Task->generateConstructor('model', 'Post');
		$expected = "ClassRegistry::init('Post');\n";
		$this->assertEqual($expected, $result);

		$result = $this->Task->generateConstructor('helper', 'FormHelper');
		$expected = "new FormHelper();\n";
		$this->assertEqual($expected, $result);
	}

/**
 * Test that mock class generation works for the appropriate classes
 *
 * @return void
 */
	public function testMockClassGeneration() {
		$result = $this->Task->hasMockClass('controller');
		$this->assertTrue($result);
	}

/**
 * test bake() with a -plugin param
 *
 * @return void
 */
	public function testBakeWithPlugin() {
		$this->Task->plugin = 'TestTest';

		//fake plugin path
		CakePlugin::load('TestTest', array('path' =>  APP . 'Plugin' . DS . 'TestTest' . DS));
		$path =  APP . 'Plugin' . DS . 'TestTest' . DS . 'Test' . DS . 'Case' . DS . 'View' . DS . 'Helper' . DS  .'FormHelperTest.php';
		$this->Task->expects($this->once())->method('createFile')
			->with($path, new PHPUnit_Framework_Constraint_IsAnything());

		$this->Task->bake('Helper', 'Form');
		CakePlugin::unload();
	}

/**
 * test interactive with plugins lists from the plugin
 *
 * @return void
 */
	public function testInteractiveWithPlugin() {
		$testApp = CAKE . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS;
		App::build(array(
			'plugins' => array($testApp)
		), true);
		CakePlugin::load('TestPlugin');

		$this->Task->plugin = 'TestPlugin';
		$path = $testApp . 'TestPlugin' . DS . 'Test' . DS . 'Case' . DS . 'View' . DS . 'Helper' . DS . 'OtherHelperHelperTest.php';
		$this->Task->expects($this->any())
			->method('in')
			->will($this->onConsecutiveCalls(
				5, //helper
				1 //OtherHelper
			));

		$this->Task->expects($this->once())
			->method('createFile')
			->with($path, $this->anything());

		$this->Task->stdout->expects($this->at(21))
			->method('write')
			->with('1. OtherHelperHelper');

		$this->Task->execute();
	}

/**
 * Test filename generation for each type + plugins
 *
 * @return void
 */
	public function testTestCaseFileName() {
		$this->Task->path = DS . 'my' . DS . 'path' . DS . 'tests' . DS;

		$result = $this->Task->testCaseFileName('Model', 'Post');
		$expected = $this->Task->path . 'Case' . DS . 'Model' . DS . 'PostTest.php';
		$this->assertEqual($expected, $result);

		$result = $this->Task->testCaseFileName('Helper', 'Form');
		$expected = $this->Task->path . 'Case' . DS . 'View' . DS . 'Helper' . DS . 'FormHelperTest.php';
		$this->assertEqual($expected, $result);

		$result = $this->Task->testCaseFileName('Controller', 'Posts');
		$expected = $this->Task->path . 'Case' . DS . 'Controller' . DS . 'PostsControllerTest.php';
		$this->assertEqual($expected, $result);

		$result = $this->Task->testCaseFileName('Behavior', 'Containable');
		$expected = $this->Task->path . 'Case' . DS . 'Model' . DS . 'Behavior' . DS . 'ContainableBehaviorTest.php';
		$this->assertEqual($expected, $result);

		$result = $this->Task->testCaseFileName('Component', 'Auth');
		$expected = $this->Task->path . 'Case' . DS . 'Controller' . DS  . 'Component' . DS . 'AuthComponentTest.php';
		$this->assertEqual($expected, $result);

		CakePlugin::load('TestTest', array('path' =>  APP . 'Plugin' . DS . 'TestTest' . DS ));
		$this->Task->plugin = 'TestTest';
		$result = $this->Task->testCaseFileName('Model', 'Post');
		$expected =  APP . 'Plugin' . DS . 'TestTest' . DS . 'Test' . DS . 'Case' . DS . 'Model' . DS . 'PostTest.php';
		$this->assertEqual($expected, $result);
	}

/**
 * test execute with a type defined
 *
 * @return void
 */
	public function testExecuteWithOneArg() {
		$this->Task->args[0] = 'Model';
		$this->Task->expects($this->at(0))->method('in')->will($this->returnValue('TestTaskTag'));
		$this->Task->expects($this->once())->method('isLoadableClass')->will($this->returnValue(true));
		$this->Task->expects($this->once())->method('createFile')
			->with(
				new PHPUnit_Framework_Constraint_IsAnything(),
				new PHPUnit_Framework_Constraint_PCREMatch('/class TestTaskTagTestCase extends CakeTestCase/')
			);
		$this->Task->execute();
	}

/**
 * test execute with type and class name defined
 *
 * @return void
 */
	public function testExecuteWithTwoArgs() {
		$this->Task->args = array('Model', 'TestTaskTag');
		$this->Task->expects($this->at(0))->method('in')->will($this->returnValue('TestTaskTag'));
		$this->Task->expects($this->once())->method('createFile')
			->with(
				new PHPUnit_Framework_Constraint_IsAnything(),
				new PHPUnit_Framework_Constraint_PCREMatch('/class TestTaskTagTestCase extends CakeTestCase/')
			);
		$this->Task->expects($this->any())->method('isLoadableClass')->will($this->returnValue(true));
		$this->Task->execute();
	}
}
