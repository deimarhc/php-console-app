# php-console-app
Cars console app

# Write a PHP application (CLI) using symfony/console with exactly one command:

    php console.php cars:query [--mpg=n] [--cylinders=n] [--displacement=n] [--horsepower=n] [--weight=n] [--acceleration=n] [--model=n] [--origin=n]

## The command should:
* Load the whole dataset (https://perso.telecom-paristech.fr/ea...) into memory.

* Display statistics, i.e. how many cars are in dataset for each feature (MPG;Cylinders;Displacement;Horsepower;Weight;Acceleration;Model;Origin). Example output:

        Origin:
          ...
          US - 254
          Japan - 79
          ...
        
        MPG:
          ...
          15.0 - 30
          16.0 - 29
          ...
        
        ...

* If command line contains any additional options - perform the search and display corresponding car names. Example output:

     Search result:
      Ford Galaxie 500
      Chevrolet Impala
      Chevrolet Chevette
