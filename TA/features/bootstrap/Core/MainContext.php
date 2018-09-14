<?php
namespace Core;

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;

/**
 * Defines application features from the specific context.
 */
class MainContext extends RawDrupalContext implements SnippetAcceptingContext {

  protected $screenshot_dir = '/tmp';
  protected $url;

  public function __construct($parameters) {
    $this->parameters = $parameters;
    if (isset($parameters['screenshot_dir'])) {
      $this->screenshot_dir = $parameters['screenshot_dir'];
    }

    if (isset($parameters['main_url'])) {
      $this->url = $parameters['main_url'];
    }
  }

  /**
   * Take screenshot when step fails. Works only with Selenium2Driver.
   * Screenshot is saved at [Date]/[Feature]/[Scenario]/[Step].jpg
   *  @AfterStep
   */
  public function after(AfterStepScope $scope) {
    if ($scope->getTestResult()->getResultCode() === 99) {
      $driver = $this->getSession()->getDriver();
      if ($driver instanceof Selenium2Driver) {
        $fileName = date('d-m-y') . '-' . uniqid() . '.png';
        $this->saveScreenshot($fileName, $this->screenshot_dir);
        print 'Screenshot at: '.$this->screenshot_dir.'/' . $fileName;
      }
    }
  }

  /**
   * Setting screen size to 1400x900 (desktop)
   *
   * @Given /^I am on the "([^"]*)"/
   */
  public function navigateToURL($pageName)
  {
    $pagePath = '';
    switch ($pageName) {
      case 'page alias':
        $pagePath='/';
      break;
      default: //for "home page"
        $pagePath='/';
      break;
    }
    $this->getSession()->visit($this->url.$pagePath);
  }

  /**
   * Setting screen size to 1400x900 (desktop)
   *
   * @Given /^the size is desktop/
   */
  public function theSizeIsDesktop()
  {
    $this->getSession()->resizeWindow(1400, 900, 'current');
  }


}
