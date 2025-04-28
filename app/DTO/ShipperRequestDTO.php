<?php


namespace App\DTO;

use Illuminate\Http\Request;

class ShipperRequestDTO
{
    public string $name;
    public ?string $email;
    public ?string $plan_fix_email;
    public ?string $plan_fix_link;
    public ?string $comment;

    public int $id;
    public int $min_sum = 0;
    public int $fill_storage = 0;

    public array $users = [];

    public function __construct($id, $name, $email, $plan_fix_email, $plan_fix_link, $comment, $min_sum, $fill_storage, $users)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->plan_fix_email = $plan_fix_email;
        $this->plan_fix_link = $plan_fix_link;
        $this->comment = $comment;
        $this->min_sum = $min_sum;
        $this->fill_storage = $fill_storage;
        $this->users = $users;
    }

    public static function makeFromRequest(Request $request, int $id)
    {
        return new self(
            $id,
            $request->input('shipper'),
            $request->input('email'),
            $request->input('plan_fix_email'),
            $request->input('plan_fix_link'),
            $request->input('comment'),
            $request->input('min_sum'),
            $request->input('fill_storage'),
            $request->input('users', []),
        );
    }

}
