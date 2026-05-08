<?php

namespace Tests\Feature\Admin\Project;

use App\Models\Admin;
use App\Models\Project;
use App\Models\TechStack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->admin = Admin::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_admin_can_view_projects_index()
    {
        $this->actingAs($this->admin, 'admin')
            ->get(route('project.index'))
            ->assertStatus(200);
    }

    public function test_admin_can_view_create_project_page()
    {
        $this->actingAs($this->admin, 'admin')
            ->get(route('project.create'))
            ->assertStatus(200);
    }

    /*
    public function test_admin_can_store_project()
    {
        Storage::fake('public');
        $techStack = TechStack::factory()->create();

        $data = [
            'title' => 'Test Project',
            'description' => 'Test Description',
            'excerpt' => 'Test Excerpt',
            'status' => 'completed',
            'featured' => true,
            'thumbnail' => UploadedFile::fake()->create('thumbnail.jpg', 100),
            'tech_stacks' => [$techStack->id],
        ];

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('project.store'), $data);

        $response->assertRedirect(route('project.index'));
        
        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'status' => 'completed',
            'featured' => 1,
        ]);

        $project = Project::first();
        $this->assertCount(1, $project->techStacks);
        $this->assertNotNull($project->thumbnail);
        Storage::disk('public')->assertExists($project->thumbnail);
    }

    public function test_admin_can_update_project()
    {
        Storage::fake('public');
        $project = Project::create([
            'title' => 'Old Title',
            'slug' => 'old-title',
            'description' => 'Old Description',
            'status' => 'ongoing',
            'featured' => false,
        ]);

        $data = [
            'title' => 'New Title',
            'description' => 'New Description',
            'status' => 'completed',
            'featured' => true,
        ];

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('project.update', $project), $data);

        $response->assertRedirect(route('project.index'));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'New Title',
            'status' => 'completed',
            'featured' => 1,
        ]);
    }

    public function test_admin_can_delete_project()
    {
        $project = Project::create([
            'title' => 'To Delete',
            'slug' => 'to-delete',
            'description' => 'Description',
            'status' => 'ongoing',
            'featured' => false,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->delete(route('project.destroy', $project));

        $response->assertRedirect(route('project.index'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
    */
}
