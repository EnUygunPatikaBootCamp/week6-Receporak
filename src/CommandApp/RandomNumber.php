<?php

namespace App\CommandApp;

use \Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RandomNumber extends Command
{
    protected static $defaultName = 'app:random-number';
protected function configure()
    {
        // İstenilen argümanlarını belirtiyoruz.
        $this
            ->addArgument('number', InputArgument::REQUIRED, 'Max number');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $number = $input->getArgument('number');
        $numbersArray = [];

        // Girilen sayı kadar array adedi üretiyoruz.
        foreach (range(1, $number) as $value) {
            $numbersArray[] = rand(1, 999);
        }

        // minimum ve maximum değerlerini buluyoruz.
        $minValue=min(array_values($numbersArray));
        $maxValue=max(array_values($numbersArray));
        // Ekrana yazdırıyoruz.
        $output->writeln('Oluşturulan sayılar: ' . implode(', ', $numbersArray));
        $output->writeln('En Büyük Sayı: '.$maxValue.' En Küçük Sayı: '.$minValue);

        return Command::SUCCESS;
    }

}