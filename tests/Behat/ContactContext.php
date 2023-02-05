<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\MinkContext;
use PHPUnit\Framework\Assert;
use function PHPUnit\Framework\assertTrue;

/**
 * This context class contains the definitions of the steps used by the contact
 * feature file.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class ContactContext extends MinkContext{
    /**
     * Opens contact page
     * Example: Given I am on "/"
     * Example: When I go to "/"
     * Example: And I go to "/"
     *
     * @Given /^(?:|I )am on (?:|the )contact page$/
     * @When /^(?:|I )go to (?:|the )contact page/
     */
    public function iAmOnContactPage()
    {
        $this->visitPath('/contact');
    }

    /**
     * @Then there is a submittable form
     */
    public function thereIsAFormWithASubmitButton() {
        $button = $this->getSubmitButton();
        $type = $button->getAttribute("type");
        Assert::assertEquals($type, "submit");
    }

    /**
     * Opens contact page
     *
     * @Then /^(?:|the form )contains a field named "(?P<fieldName>[^"]+)"$/
     */
    public function formContainsField($fieldName)
    {
        Assert::assertTrue($this->getForm()->hasField($fieldName));
    }


    /**
     * fields are required
     *
     * @Then these form fields are required:
     */
    public function formFieldsAreRequired(TableNode $fieldsTableNode)
    {
        $form = $this->getForm();
        $fields = $fieldsTableNode->getColumn(0);
        foreach ($fields as $fieldName) {
            Assert::assertTrue($form->findField($fieldName)->hasAttribute("required"));
        }
    }

    /**
     * fields are empty
     *
     * @Then these form fields are empty:
     */
    public function formFieldsAreEmpty(TableNode $fieldsTableNode)
    {
        $form = $this->getForm();
        $fields = $fieldsTableNode->getColumn(0);
        foreach ($fields as $fieldName) {
            $fieldValue = $form->findField($fieldName)->getValue();
            Assert::assertEmpty($fieldValue);
        }
    }

    /**
     * @Then a POST request has been sent with my message
     */
    public function aPostRequestHasBeenSentWithMyMessage() {
        try {
            $headers = $this->getSession()->getResponseHeaders();
            assertTrue($headers);
        } catch (UnsupportedDriverActionException|DriverException $e) {
            // DO NOTHING
            assertTrue(false);
        }
    }

    /**
     * submit button is disabled
     *
     * @Then the submit button is disabled
     */
    public function submitBtnIsDisabled()
    {
        Assert::assertTrue($this->getSubmitButton()->hasAttribute("disabled"));
    }

    private function getForm(): NodeElement
    {
        $form = $this->getSession()->getPage()->find('css', 'form');
        Assert::assertNotNull($form, "the html form was not found");
        return $form;
    }

    private function getSubmitButton(): NodeElement
    {
        $btnLocator = "message_submitMessage";
        $button = $this->getForm()->findButton($btnLocator);
        Assert::assertNotNull($button, "the $btnLocator button was not found");
        return $button;

    }
}
