<?php

namespace App\Domain\Entities;

use DomainException;

class UserEntity
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $document;
    private string $customerType;

    public function __construct(
        private readonly ?int    $id,
        string                   $firstName,
        string                   $lastName,
        string                   $email,
        string                   $document,
        private readonly string  $phone,
        private readonly string  $birthDate,
        private readonly ?string $password = null,
    )
    {
        $this->firstName = $this->formatName($firstName);
        $this->lastName = $this->formatName($lastName);
        $this->email = strtolower($email);
        $this->document = $this->sanitizeDocument($document);
        $this->customerType = $this->detectCustomerType($this->document);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDocument(): string
    {
        return $this->document;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function getCustomerType(): string
    {
        return $this->customerType;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    private function formatName(string $name): string
    {
        return mb_convert_case(trim($name), MB_CASE_TITLE, "UTF-8");
    }

    private function sanitizeDocument(string $document): string
    {
        return preg_replace('/[^0-9]/', '', $document);
    }

    public function detectCustomerType(string $document): string
    {
        if (strlen($document) === 11) {
            return 'common';
        }

        if (strlen($document) === 14) {
            return 'merchant';
        }

        throw new DomainException('Documento inválido');
    }

    public function getFormattedDocument(): string
    {
        if ($this->customerType === 'common') {
            return preg_replace(
                "/(\d{3})(\d{3})(\d{3})(\d{2})/",
                "$1.$2.$3-$4",
                $this->document
            );
        }

        return preg_replace(
            "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/",
            "$1.$2.$3/$4-$5",
            $this->document
        );
    }

    public function getFormattedPhone(): string
    {
        if (strlen($this->phone) === 11) {
            return preg_replace(
                "/(\d{2})(\d{5})(\d{4})/",
                "($1) $2-$3",
                $this->phone
            );
        }

        return preg_replace(
            "/(\d{2})(\d{4})(\d{4})/",
            "($1) $2-$3",
            $this->phone
        );
    }
}
