# Contact page user story
# http://behat.org/en/latest/quick_start.html

Feature:
  Nous souhaiterions mettre en place un formulaire de contact sur notre site.
  Le formulaire de contact doit être simple :
  il doit nous permettre de connaitre les coordonnées de l'internaute, et sa question.
  Il nous faut au moins son nom, son email, et sa question pour que nous traitions sa demande.

  Scenario: I can navigate to the contact page
    When I am on the contact page
    Then the response status code should be 200

  @javascript
  Scenario: I can open the contact page in the Browser
    When I am on the contact page
    Then I should see "Nous contacter" in the "h2" element
    And there is a submittable form
    And the form contains a field named "message_username"
    And the form contains a field named "message_email"
    And the form contains a field named "message_content"
    And these form fields are required:
      | message_username |
      | message_email |
      | message_content |
    And these form fields are empty:
      | message_username |
      | message_email |
      | message_content |

    @javascript
    Scenario: I can post a message from the contact page
      When I am on the contact page
      And I fill in the following:
        | message_username | Anne Auny-Mousse |
        | message_email | anne.auny-mousse@protonmail.com |
        | message_content | "Hello world" |
      And I press "message_submitMessage"
      Then a POST request has been sent with my message