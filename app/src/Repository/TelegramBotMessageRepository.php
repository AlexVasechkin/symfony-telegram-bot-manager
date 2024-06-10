<?php

namespace App\Repository;

use App\Entity\TelegramBotMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TelegramBotMessage>
 */
class TelegramBotMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TelegramBotMessage::class);
    }

    /**
     * @param int $limit
     * @return TelegramBotMessage[]
     */
    public function getMessagesToSend(int $limit = 50): array
    {
        $qb = $this->createQueryBuilder('m');

        $qb->where('1 = 1');

        $qb->andWhere('m.isSent = :sent');
        $qb->setParameter('sent', false);

        $qb->orderBy('m.priority');
        $qb->orderBy('m.createdAt');

        $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
