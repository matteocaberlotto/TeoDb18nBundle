<?php

namespace Teo\Db18nBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;

class DumpLabelsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('teo:i18n:dump')
            ->setDefinition(array(
                new InputArgument('locale', InputArgument::REQUIRED, 'The locale'),
                new InputArgument('bundle', InputArgument::REQUIRED, 'The bundle where to load the messages'),
                new InputOption(
                    'dump-messages', null, InputOption::VALUE_NONE,
                    'Should the messages be dumped in the console'
                ),
                new InputOption(
                    'force', null, InputOption::VALUE_NONE,
                    'Should the update be done'
                )
            ))
            ->setDescription('Warms up an empty cache')
            ->setHelp(<<<EOF
Dump labels to file in order to avoid db access and speed up things
EOF
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getOption('dump-messages') && !$input->getOption('force')) {
            $output->writeln('<error>You should either chose to print or dump labels to file</error>');
            return 1;
        }

        $allLabels = $this->getContainer()->get('doctrine')->getRepository('Teo\Db18nBundle\Entity\Label')->findAll();

        $locale = $input->getArgument('locale');

        $labels = array();

        foreach ($allLabels as $label) {
            $translation = $this->getContainer()->get('doctrine')->getRepository('Teo\Db18nBundle\Entity\LabelTranslation')->findOneBy(array(
                'locale' => $locale,
                'translatable' => $label
                ));

            if ($translation) {
                $labels [$label->getName()]= $translation->getContent();
            }
        }

        if ($input->getOption('dump-messages')) {
            $output->writeln($locale);
            foreach ($labels as $index => $label) {
                $output->write($this->getStringFor($index, $label));
            }
        }

        if ($input->getOption('force')) {
            $this->dumpAllLabelsForLocale($labels, $locale, $input);
        }
        //
    }


    public function dumpAllLabelsForLocale($labels, $locale, $input)
    {
        $filename = 'messages.' . $locale . '.yml';

        $foundBundle = $this->getApplication()->getKernel()->getBundle($input->getArgument('bundle'));
        $bundleTransPath = $foundBundle->getPath().'/Resources/translations';
        $file = $bundleTransPath . '/' . $filename;

        $string = '';
        foreach ($labels as $index => $label) {
            $string .= $this->getStringFor($index, $label);
        }

        file_put_contents($file, $string);
    }

    protected function getStringFor($index, $label) {
        return sprintf("'%s':'%s'\r\n", $this->escapeQuotes($index), $this->escapeQuotes($label));
    }

    protected function escapeQuotes($string)
    {
        return str_replace("'", "\'", $string);
    }
}