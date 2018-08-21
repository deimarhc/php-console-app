<?php

namespace Cars\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class CarsCommand.
 */
class CarsCommand extends Command {

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
            // The command name.
            ->setName('cars:query')
            // The command description.
            ->setDescription('Shows information based on cars.csv file.')
            // The command options.
            ->addOption('mpg', null, InputArgument::OPTIONAL, 'The car mpg')
            ->addOption('cylinders', null, InputArgument::OPTIONAL, 'The car cylinders')
            ->addOption('displacement', null, InputArgument::OPTIONAL, 'The car displacement')
            ->addOption('horsepower', null, InputArgument::OPTIONAL, 'The car horsepower')
            ->addOption('weight', null, InputArgument::OPTIONAL, 'The car weight')
            ->addOption('acceleration', null, InputArgument::OPTIONAL, 'The car acceleration')
            ->addOption('model', null, InputArgument::OPTIONAL, 'The car model')
            ->addOption('origin', null, InputArgument::OPTIONAL, 'The car origin');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $output
            // Header message.
            ->writeln([
                '===== Display and query cars =====',
                '==================================',
                '',
            ]);
        // Load the whole dataset (https://perso.telecom-paristech.fr/ea...) into memory.
        if (($handle = fopen(DATA_DIR . '/cars.csv', "r")) !== FALSE) {
            $row = 0;
            $stats = [];
            while(($data = fgetcsv($handle, 0, ';')) !== FALSE) {
                if ($row > 1) {
                    for ($i=0; $i < count($data); $i++) {
                        if (!isset($stats[$i][$data[$i]])) $stats[$i][$data[$i]] = [];
                        $stats[$i][$data[$i]][] = $row;
                    }                    
                }

                $cars[] = $data;
                $row++;
            }
            fclose($handle);

            $header = $cars[0];
            // Display statistics, i.e. how many cars are in dataset for each feature.
            for ($i=0; $i < count($header); $i++) {
                $output->writeln($header[$i]);
                $temp = [];
                foreach ($stats[$i] as $key => $value) {
                    $temp[$key] = count($value);
                }
                arsort($temp);
                foreach ($temp as $key => $value) {
                    $output->writeln('   ' . $key . ':  '. $value);
                }
            }

            $matches = [];
            $search_requested = FALSE;
            for ($i=1; $i < count($header); $i++) { 
                $c = $input->getOption(strtolower($header[$i]));
                if (!is_null($c)) {
                    $search_requested = TRUE;
                    if(isset($stats[$i][$c])) $matches[] = $stats[$i][$c];
                }
            }

            if ($search_requested) {
                if ($matches) {
                    if (count($matches) > 1) $intersect = array_intersect(...$matches); else $intersect = $matches[0];
                    $output->writeln(['', 'Search result:']);
                    foreach ($intersect as $key => $value) {
                        $output->writeln('   ' . $cars[$value][0]);
                    }
                }
                else {
                    $output->writeln(['', 'No results found.']);
                }
            }
        }
    }
}
