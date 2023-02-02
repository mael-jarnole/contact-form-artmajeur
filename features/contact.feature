# Contact page user story
# http://behat.org/en/latest/quick_start.html

Feature:
    Nous souhaiterions mettre en place un formulaire de contact sur notre site.
    Le formulaire de contact doit être simple :
    il doit nous permettre de connaitre les coordonnées de l'internaute, et sa question.
    Il nous faut au moins son nom, son email, et sa question pour que nous traitions sa demande.

    Scenario: I can navigate to the homepage
        When I am on the homepage
        Then the response status code should be 200

    @javascript
    Scenario: I can open the contact page in the Browser
        When I am on the homepage
        Then I should see "Nous contacter" in the "h1" element
        And the "username" field should contain ""
        And the "email" field should contain ""
        And the "message" field should contain ""