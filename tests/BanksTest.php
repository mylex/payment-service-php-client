<?php

use PaymentService\Bank;

/**
*
*/
class BanksTest extends TestCase
{
    private $attributes = [
        'user_id' => 1,
        'bank_name' => 'Test Bank',
        'bank_code' => '123',
        'branch_name' => 'Test BRanch',
        'branch_code' => '456',
        'account_type' => 1,
        'account_no' => '7654321',
        'account_name' => 'New name',
        'bank_type' => 1
    ];

    /** @test */
    public function it_retreive_all()
    {
        $this->mockRequest('GET', '/banks', [], $this->collectionResource());
        $banks = Bank::all();
        $this->assertEquals('PaymentService\Base\Collection', get_class($banks));
    }

    /** @test */
    public function it_retreives_bank_by_a_specific_user()
    {
        $userId = 1234;
        $this->mockRequest('GET', '/banks?user_id='.$userId, ['user_id'=>$userId], $this->collectionResource());
        $banks = Bank::all([
            'user_id' => $userId
        ]);
        $this->assertEquals('PaymentService\Base\Collection', get_class($banks));
    }

    /** @test */
    public function it_omits_non_acceptable_query_parameters()
    {
        $userId = 1234;
        $params = [
            'user_id' => $userId
        ];
        $this->mockRequest('GET', '/banks?user_id='.$userId, $params, $this->collectionResource());
        $banks = Bank::all([
            'user_id' => $userId,
            'account_no' => 7654321
        ]);
        $this->assertEquals('PaymentService\Base\Collection', get_class($banks));
    }

    /** @test */
    public function it_retreive_a_single_bank_account()
    {
        $id = 1;
        $this->mockRequest('GET', '/banks/' . $id, [], $this->instanceResource($id));
        $bank = Bank::get($id);
        $this->assertSame($bank->id, $id);
    }

    /** @test */
    public function it_creates_new_bank_account()
    {
        $id = 1;
        $jsonData = $this->makeJosnData();
        $this->mockRequest('POST', '/banks', $jsonData, $this->instanceResource($id));
        $bank = Bank::create($this->attributes);
        $this->assertSame($bank->id, $id);
    }

    /** @test */
    public function it_updates_an_account()
    {
        $id = 6;
        $jsonData = $this->makeJosnData($id);
        $updated = $this->updatedInstanceResource($id);
        $this->mockRequest('GET', '/banks/' . $id, [], $this->instanceResource($id));
        $this->mockRequest('PATCH', '/banks/' . $id, $jsonData, $updated);
        $this->mockRequest('GET', '/banks/' . $id, [], $updated);
        $bank = Bank::get($id);
        $bank->account_name = 'New name';
        $bank->save();
        $updatedBank = Bank::get($id);
        $this->assertSame($updatedBank->account_name, 'New name');
    }

    /** @test */
    public function it_deletes_an_account()
    {
        $id = 6;
        $this->mockRequest('GET', '/banks/' . $id, [], $this->instanceResource($id));
        $this->mockRequest('DELETE', '/banks/' . $id, [], [], 204);
        $this->mockRequestWithException('GET', '/banks/' . $id, [], [], 404);
        $bank = Bank::get($id);
        $bank->delete();
        $this->expectException(\Exception::class);
        $deletedBank = Bank::get($id);
    }

    private function updatedInstanceResource($id)
    {
        return [
            'data' => [
                'type' => 'banks',
                'id' => $id,
                'attributes' => $this->attributes
            ]
        ];
    }

    private function instanceResource($id)
    {
        return [
            'data' => [
                'type' => 'banks',
                'id' => $id,
                'attributes' => $this->attributes
            ]
        ];
    }

    private function collectionResource()
    {
        return [
            'data' => [
                'data' => [
                    'type' => 'banks',
                    'id' => 1,
                    'attributes' => []
                ],
                'data' => [
                    'type' => 'banks',
                    'id' => 2,
                    'attributes' => []
                ],
            ]
        ];
    }

    private function makeJosnData($id = null)
    {
        $jsonData = [
            'data' => [
                'type' => 'banks',
                'attributes' => $this->attributes
            ]
        ];
        if ($id) {
            $jsonData['data']['id'] = $id;
        }
        return $jsonData;
    }
}
