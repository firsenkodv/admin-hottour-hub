<?php

namespace Domain\Identity\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class IdentityAccountQueryBuilder extends Builder
{
    public function byEmail(string $email): static
    {
        return $this->where('email', $email);
    }

    public function byResetToken(string $token): static
    {
        return $this->where('reset_token', $token)
            ->where('reset_token_expires_at', '>=', now());
    }
}
