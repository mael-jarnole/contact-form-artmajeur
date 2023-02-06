<?php

namespace App\Service;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Component\Filesystem\Filesystem;

class ContactMessageService
{
    private const DATA_MESSAGES_DIRECTORY = '../data/messages';
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param Message $contactMessage
     * @return void
     */
    public function createMessage(Message $contactMessage): void
    {
        $this->messageRepository->save($contactMessage, true);
        $this->writeToJsonFile($contactMessage);
    }

    /**
     * @param Message $contactMessage
     * @return void
     */
    public function writeToJsonFile(Message $contactMessage): void
    {
        $filesystem = new Filesystem();

        if (!$filesystem->exists(self::DATA_MESSAGES_DIRECTORY)) {
            $filesystem->mkdir(self::DATA_MESSAGES_DIRECTORY);
        }

        $filesystem->dumpFile(
            self::DATA_MESSAGES_DIRECTORY . '/' . $contactMessage->getId() . '.json'
            , json_encode($contactMessage)
        );
    }
}