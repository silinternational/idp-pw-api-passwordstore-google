Feature: Google integrations

  Scenario: Getting user password metadata
    Given I can make authenticated calls to Google
    When I ask Google for a specific user's metadata
    Then I should get back metadata about that user's password
