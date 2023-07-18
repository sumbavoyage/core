<?php

namespace Svs\Core\Command\Review;

use Svs\Core\Entity\GoogleReview;
use Svs\Core\Entity\Setting;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 */
class UpdateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('svs:core:review:update')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container = $this->getApplication()->getKernel()->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
        $googleReviewRepository = $this->em->getRepository(GoogleReview::class);

        $cid = '16767425702343320997';   // The CID you want to see the reviews for

        $ch = curl_init('https://www.google.com/maps?cid='.$cid);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla / 5.0 (Windows; U; Windows NT 5.1; en - US; rv:1.8.1.6) Gecko / 20070725 Firefox / 2.0.0.6");
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
        $result = curl_exec($ch);
        curl_close($ch);

        $pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';

        if (preg_match($pattern, $result, $match)) {
            $match[1] = trim($match[1], ' =;'); // fix json
            $reviews = json_decode($match[1]);
            $reviews = ltrim($reviews[3][6], ")]}'"); // fix json
            $reviews = json_decode($reviews);

            $setting = $this->em->getRepository(Setting::class)->findOneBy([]);

            if (null === $setting) {
                $setting = new Setting();
            }

            $setting
                ->setReviewsScore($reviews[6][4][7])
                ->setReviewsCount($reviews[6][4][8])
            ;

            $this->em->persist($setting);
            $this->em->flush();

            $reviews = $reviews[6][52][0]; // NEW IN 2020
        }

        if (isset($reviews)) {
            foreach ($reviews as $review) {
                $entity = $googleReviewRepository->findOneBy([
                    'fullName' => $review[0][1],
                ]);

                if (null === $entity) {
                    $entity = new GoogleReview();
                }

                $date = new \DateTime();
                $date->setTimestamp($review[57] / 1000);

                $entity
                    ->setDate($date)
                    ->setFullName($review[0][1])
                    ->setImageUrl($review[0][2])
                    ->setDescription($review[3])
                    ->setScore($review[4])
                ;

                $this->em->persist($entity);
                $this->em->flush();
            }
        }

        return Command::SUCCESS;
    }
}
