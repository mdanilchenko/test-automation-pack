@javascript
Feature: Home page navigation

Scenario: Check menu items on Home page
  Given I am on the "home page"
  And the size is desktop
  Then I should see text matching "Мобильные телефоны"
  And I should see text matching "Ноутбуки"
  When I follow "Мобильные телефоны"
  Then I should see text matching "Производитель"
