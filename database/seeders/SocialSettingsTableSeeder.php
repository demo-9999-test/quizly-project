<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SocialSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('social_settings')->delete();
        
        \DB::table('social_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'facebook_client_id' => 'eyJpdiI6ImJ6b0lXTktwRFEwbVJUZDJpVGxoRlE9PSIsInZhbHVlIjoiUU5iQnU1MytqYzAyQ3hyeGRlbHVDbFJsY3ZRZHliM1FFdXVZOVFnaUY0az0iLCJtYWMiOiJjYmFmMjE2MzNjYjBkZmEwZWE5ZDQxMjNmMmI1MmRiMTlmNGJlZTU2YjU3OWU3NDhlNDI3Y2RhMmI5OGRlMzUwIiwidGFnIjoiIn0=',
                'facebook_client_key' => 'eyJpdiI6IkI4SmhRcGhSVDVXMStQbEM1eUlVWkE9PSIsInZhbHVlIjoiSXlUNURkS0w5NDZGMzVzM3hrbGtpQVQrRElXemM2WWVzMHp6eTlCS3RPTT0iLCJtYWMiOiJmMWI0ODRkOGMxOTdiMTM0MzFhOWIyMWQ1N2I0NTFlNGE1OTEwZDE4ZmFjZTY1YzI0MDgxNjJhMTkzODc0NTFiIiwidGFnIjoiIn0=',
                'facebook_callback_url' => 'https://www.cogozili.cm',
                'facebook_status' => 1,
                'google_client_id' => 'eyJpdiI6Inh1MDh2c0dKVDdaV25oQkNFOUpYVHc9PSIsInZhbHVlIjoiTFpMcG5JTFpBZ3lmSkNJbWNBa3RMTjdaenVxYk1la0x4NHpReXNRb05YOD0iLCJtYWMiOiJkMjI0ZGE2ZWI5ZTk5NjFlYjlmNWRmMGUzNzBmNzg3NDg1YmRmM2E4YmNmYzI2ZDMwNDRkNGNiMTcyZTdhZTZmIiwidGFnIjoiIn0=',
                'google_client_key' => 'eyJpdiI6InlRREdkUW5IZjJEdGtZVkdIOHdTQWc9PSIsInZhbHVlIjoieUNIbkphLzd0TGx5WEZZQXJESmhoaXEvVTNsRHp5am1VWnBpSmx4VTRYaz0iLCJtYWMiOiJmZWM5M2RjYzBjNzhmYTQyYzBhNjM0MzdlODY2YWFhZmE0NTQzNDAwMmI0ZGIzZTlmM2EwMWFiNGQxYWYyMjllIiwidGFnIjoiIn0=',
                'google_callback_url' => 'https://www.ropylinosijig.com.au',
                'google_status' => 1,
                'gitlab_client_id' => 'eyJpdiI6IjJDT2NtRFRQaUhxdnN5aXhUMTZLYmc9PSIsInZhbHVlIjoic3NIU0NHK21XWDBPd1ZlZXVERGhJb1Y0dlh3S1o1M2NXMnhRUEUrRHFZUT0iLCJtYWMiOiI5OWY3YmE3MTJhMjkxZjk3NGU2NDQ1MjgyZTkzNDViMzg3ZGI2YTE4OTQ3MjQ1ZDcxMjFhMjY2YTllYjIyOGY0IiwidGFnIjoiIn0=',
                'gitlab_client_key' => 'eyJpdiI6InFNcnNIY1dhczlrbE9HY25pNmd5NXc9PSIsInZhbHVlIjoiNTR2MVJuNUZtQS9nOXA2Ly83d09jS2RTZ3hXb1JkUUg5MFljOEYzYytocz0iLCJtYWMiOiI0NGM4MTg2NWQ0NzA3N2ZmNzhkNzY2ZGMxYTFhM2NiMDg4Y2IwNTFhNjg2OWJmMzZlYjA1NDZmZjhhNzcyYWYxIiwidGFnIjoiIn0=',
                'gitlab_callback_url' => 'https://www.nydar.net',
                'gitlab_status' => 1,
                'amazon_client_id' => 'eyJpdiI6Incxa2k5L0dxazA4Y1pyYWJON1FtQnc9PSIsInZhbHVlIjoiUVZOY04vZ0ZTU0VIS3dUZk1LWjJxUUUwb0UrcTRLNTg4SHQ3MHduTkFXOD0iLCJtYWMiOiIwMDgzYzMxYTMwYmUzM2ZlOGFkMjMwMGExYTA1M2U0ZTVjN2I3OWFiMzhhOTA2ZGI3OWZkOThiMjdhMDc2NDY4IiwidGFnIjoiIn0=',
                'amazon_client_key' => 'eyJpdiI6IkJBRkpOdDJwL21LOGcwS3MrMFJHbHc9PSIsInZhbHVlIjoiN1NIVnd5L1VneWdhRXM3eUdxQzVDV2xMbGl0N2VvRVZSbFNlYVFoNFdWVT0iLCJtYWMiOiI1ZjFmMjU1NDQ2ZTNkYTIxYTRhYzczNzNlMzNjMDYzMDhhNTliNjU2ZjU4OTRmZmQ3ZmQ0NjEwZDZkNjZmNjBkIiwidGFnIjoiIn0=',
                'amazon_callback_url' => 'https://www.pytodosoxenipyh.ca',
                'amazon_status' => 1,
                'linkedin_client_id' => 'eyJpdiI6IjAvWStIaUJpVXVOQnUxUWtrQ3EzMEE9PSIsInZhbHVlIjoiaEoweEpTVGFuTmlOTmJmT0Z4VFBuMC9WckZrSFpKZnpxaEVhTXg5dlpVbz0iLCJtYWMiOiI3MzBjZTk2OWYwYjJlZTY4ZDEyZmE0OTJjNTE4NTZlN2ZlOWUxMzYyYmFhN2ZkOWYyYjU3YzliYjFlYjE5OTg1IiwidGFnIjoiIn0=',
                'linkedin_client_key' => 'eyJpdiI6IlJKcWM3enBGRlg3NmZ3Zk5PVVo2eFE9PSIsInZhbHVlIjoiZ2Q4WUJ6Zk5SalVtZFV6akQzV0NaYnpSbzRESzU0ZHlUNExhajdQZHY1dz0iLCJtYWMiOiI3NmFkMWQzOGRlNjY0OGQwODY5NDljMjU4YWVmNGI3YzdlZTEwYWFkMTIyYjA1OWFlNGViYTRkN2QxZDU3OTY2IiwidGFnIjoiIn0=',
                'linkedin_callback_url' => 'https://www.kogudomip.mobi',
                'linkedin_status' => 1,
                'twitter_client_id' => 'eyJpdiI6ImMzb0VYK09XK21pUExybTFnVnZlL2c9PSIsInZhbHVlIjoibjIyMzN1VkNXSjNFUDk2T05TcEFFMktZbnVqbkZ0V3pldHM5K3ZHQllYbz0iLCJtYWMiOiI5ODM5ZWI4YTJlY2Q1N2RjMGRmYTY5YmUzMThjNTg2OWQ0NjRlMWIwMzZmMDAyZDc4OWEzOGJmMTkyMjM2MDZmIiwidGFnIjoiIn0=',
                'twitter_client_key' => 'eyJpdiI6IlJnaTY0a29qL25vdW1aNVQxS0h2SXc9PSIsInZhbHVlIjoiWWFXU3BVdWo1OWdibi9RbzROcC9mSDdNdzBYYmNENi8xTGZRcHVnc3N2dz0iLCJtYWMiOiIxNTAyYTE5NjUwMTRlYTczYjdkNjY3ZDZhM2IwNmZjM2MwODdjMDc3ZGVhYjE4OTU5YTc5ZWI5Y2I1YzFmZDJiIiwidGFnIjoiIn0=',
                'twitter_callback_url' => 'https://www.dyzihyn.co.uk',
                'twitter_status' => 1,
                'created_at' => '2024-01-02 07:35:18',
                'updated_at' => '2024-01-02 07:56:01',
            ),
        ));
        
        
    }
}