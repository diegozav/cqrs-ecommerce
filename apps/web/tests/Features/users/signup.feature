Feature: Signup user
    In order access to the system
    As a user
    I want to register with basic info

    Scenario: Try to register an existing user
        Given there are users with the following details:
            | id                                   | name           | email                | password   |
            | be324fa6-03b9-49f8-92e3-c15e9974cbfa | Jon Doe        | jon.doe98@gmail.com  | Laaaa23456 |
            | 2c77189e-aefd-413a-8aaa-7018854d46b2 | Diego Zavaleta | diegozav99@gmail.com | Laaaa23456 |
        When I send a POST request to "/users" with body:
        """
        {
            "name": "Diego Zavaleta",
            "email": "diegozav99@gmail.com",
            "password": "Laaaa23456"
        }
        """
        Then the response status code should be 400
        And the response content should be:
        """
        {
            "message": "User with email diegozav99@gmail.com already exists"
        }
        """

    Scenario: Try to register an non existing user with invalid fields
        When I send a POST request to "/users" with body:
        """
        {
            "name": "Diego Zavaleta",
            "email": "diegozav99@",
            "password": "Laaaa"
        }
        """
        Then the response status code should be 400
        And the response content should be:
        """
        {
            "valid": false,
            "errors": [
                {
                    "field": "#/email",
                    "error": "The data must match the 'email' format"
                },
                {
                    "field": "#/password",
                    "error": "Minimum string length is 8, found 5"
                }
            ]
        }
        """

    Scenario: Register a non existing user
        When I send a POST request to "/users" with body:
        """
        {
            "name": "Diego Zavaleta",
            "email": "diegozav99@gmail.com",
            "password": "Laaaa23456"
        }
        """
        Then the response status code should be 201
        And the response content should have the following schema:
        """
        {
            "type": "object",
            "properties": {
                "id": {
                    "type": "string"
                }
            },
            "required": ["id"]
        }
        """
