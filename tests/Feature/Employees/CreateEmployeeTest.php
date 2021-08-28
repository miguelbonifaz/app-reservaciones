<?php

namespace Tests\Feature\Employees;

use App\Models\Employee;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEmployeeTest extends TestCase
{
    use RefreshDatabase;

    private function createEmployee($data = [])
    {
        $url = route('employees.store');

        return $this->actingAsUser()->post($url, $data);
    }

    /** @test */
    public function can_see_create_employee_form()
    {
        // Arrange

        // Act
        $url = route('employees.create');

        $response = $this->actingAsUser()->get($url);

        // Assert
        $response->assertOk();

        $response->assertViewIs('employees.create');

        $response->assertViewHas('employee');
    }

    /** @test */
    public function can_create_a_employee()
    {
        // Arrange
        /** @var Employee $data */
        $data = Employee::factory()
            ->hasAttached($service = Service::factory()->create())
            ->hasAttached($location = Location::factory()->create())
            ->make();

        // Act
        $response = $this->createEmployee([
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'servicesId' => [$service->id],
        ]);

        // Assert
        $response->assertRedirect(route('employees.index'));

        $response->assertSessionHas('flash_success', 'Se creó con éxito el empleado.');

        $this->assertCount(1, Employee::all());

        $employee = Employee::first();
        $this->assertEquals($data->name, $employee->name);
        $this->assertEquals($data->email, $employee->email);
        $this->assertEquals($data->phone, $employee->phone);

        $this->assertCount(1, $employee->services);
        $this->assertEquals($service->id, $employee->services->first()->id);

        $this->assertCount(0, Schedule::all());
    }

    /** @test */
    public function fields_are_required()
    {
        // Arrange
        //Act
        $response = $this->createEmployee([
            'name' => null,
            'email' => null,
            'phone' => null,
        ]);

        //Assert
        $response->assertSessionHasErrors([
            'name',
            'email',
            'phone',
        ]);
    }

    /** @test */
    public function field_servicesId_is_required()
    {
        // Arrange

        //Act
        $response = $this->createEmployee([
            'servicesId' => null,
        ]);

        //Assert
        $response->assertSessionHasErrors([
            'servicesId',
        ]);
    }

    /** @test */
    public function field_phone_must_be_a_number()
    {
        // Arrange
        /** @var Employee $employee */
        $employee = Employee::factory()->create();

        // Act
        $response = $this->createEmployee([
            'phone' => 'phone Number String',
        ]);

        // Assert
        $response->assertSessionHasErrors([
            'phone',
        ]);
    }

    /** @test */
    public function field_email_must_be_valid()
    {
        // Arrange
        // Act
        $response = $this->createEmployee([
            'email' => 'not-email',
        ]);

        // Assert
        $response->assertSessionHasErrors([
            'email',
        ]);
    }

    /** @test */
    public function email_must_be_unique()
    {
        // Arrange
        /** @var Employee $employee */
        $employee = Employee::factory()->create();

        // Act
        $response = $this->createEmployee([
            'email' => $employee->email,
        ]);

        // Assert
        $response->assertSessionHasErrors([
            'email',
        ]);
    }
}
