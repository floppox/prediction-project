#Championsip Prediction

This is created as a test task for Insider company.

## Task
In this project, we expect you to complete a simulation. In this simulation, there will be a group of
football teams and the simulation will show match results and the league table. Your task is to estimate
the final league table.

League Rules:

-There will be four teams in the league (if you wish, you can choose teams that have different strengths
and you can determine the results of the matches depending on the strengths of these selected teams).

-Other rules in the league (scoring, points, goal difference, etc.) will be the same as the rules of the
Premier League.

## Demo

http://ec2-18-184-225-237.eu-central-1.compute.amazonaws.com/

Minimal admin panel:  
http://ec2-18-184-225-237.eu-central-1.compute.amazonaws.com/admin  
login: `admin@admin.com`  
password: `admin`  

Go to Apps -> Clubs to manage teams.


## Implementation details 

- the project is based on Laravel 8.0 and running on php8, mysql:8, nginx, driven by Docker
- the pretty new Vemto (https://vemto.app/) tool is used to generate project stub, models and simple admin pannel.
- frontend is implemented with VueMaterial (https://vuematerial.io/) framework. It's made using KISS principle and doesn't show 
  the best code design because the frontend was not the priority
- the code, responsible to prediction is encapsulated in `Services\PredictionService` 
  and `Calculators\...` classes. Unfortunately it's still messy enough and implementation is not mathematically strict.
  The consultation of a professional mathematician would be needed if enyone wants to improve this.
- On php8 we could not use domain-related word Match because `match` became the keyword. 
  That's why Meet was considered instead. Also Clubs was considered for teams.