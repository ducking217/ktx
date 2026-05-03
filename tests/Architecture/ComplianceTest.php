<?php

/**
 * Architecture Compliance Tests
 * 
 * Các bài test này tự động kiểm tra tính tuân thủ kiến trúc của hệ thống.
 * Do môi trường hiện tại chưa cài đặt đầy đủ Pest, các test này được viết dưới dạng PHPUnit.
 */

namespace Tests\Architecture;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

class ComplianceTest extends TestCase
{
    /**
     * 1. Controllers không vượt quá 8 public methods.
     */
    public function test_controllers_should_not_exceed_8_public_methods()
    {
        $controllers = File::allFiles(app_path('Http/Controllers'));
        
        foreach ($controllers as $file) {
            if ($file->getExtension() !== 'php') continue;
            
            $content = file_get_contents($file->getRealPath());
            
            // Regex tìm các public function (không bao gồm __construct)
            preg_match_all('/^\s+public function (?!__construct)(\w+)/m', $content, $matches);
            
            $methodCount = count($matches[1]);
            $this->assertLessThanOrEqual(
                8, 
                $methodCount, 
                "Controller [{$file->getRelativePathname()}] vi phạm: có {$methodCount} methods (vượt quá 8)."
            );
        }
    }

    /**
     * 2. Enums có method label().
     */
    public function test_enums_must_have_label_method()
    {
        $enumPath = app_path('Enums');
        if (!File::isDirectory($enumPath)) {
            $this->markTestSkipped('Thư mục app/Enums không tồn tại.');
        }

        $enums = File::allFiles($enumPath);
        
        foreach ($enums as $file) {
            if ($file->getExtension() !== 'php') continue;
            
            $content = file_get_contents($file->getRealPath());
            
            // Chỉ kiểm tra các backed enums (string)
            if (str_contains($content, 'enum ') && str_contains($content, ': string')) {
                $this->assertStringContainsString(
                    'public function label()', 
                    $content, 
                    "Enum [{$file->getRelativePathname()}] thiếu method label()."
                );
            }
        }
    }

    /**
     * 3. Services phải có Interface tương ứng trong Contracts/.
     */
    public function test_services_must_have_corresponding_interface_in_contracts()
    {
        $servicePath = app_path('Services');
        if (!File::isDirectory($servicePath)) {
            $this->markTestSkipped('Thư mục app/Services không tồn tại.');
        }

        $services = File::allFiles($servicePath);
        
        foreach ($services as $file) {
            $filename = $file->getFilename();
            if (!str_ends_with($filename, 'Service.php')) continue;
            
            $serviceName = str_replace('.php', '', $filename);
            $interfaceName = $serviceName . 'Interface.php';
            
            // Tìm Interface trong thư mục Contracts
            $contracts = File::allFiles(app_path('Contracts'));
            $found = false;
            foreach ($contracts as $contract) {
                if ($contract->getFilename() === $interfaceName) {
                    $found = true;
                    break;
                }
            }
            
            $this->assertTrue(
                $found, 
                "Service [{$serviceName}] thiếu Interface tương ứng [{$interfaceName}] trong app/Contracts/."
            );
        }
    }

    /**
     * 4. Không có string tiếng Việt raw trong các câu lệnh where().
     */
    public function test_no_raw_vietnamese_strings_in_where_queries()
    {
        $servicePath = app_path('Services');
        if (!File::isDirectory($servicePath)) {
            $this->markTestSkipped('Thư mục app/Services không tồn tại.');
        }

        $services = File::allFiles($servicePath);
        
        foreach ($services as $file) {
            if ($file->getExtension() !== 'php') continue;
            
            $content = file_get_contents($file->getRealPath());
            
            // Regex tìm ->where() chứa ký tự Unicode tiếng Việt
            // Ký tự tiếng Việt Unicode: \x{00C0}-\x{1EF9}
            $pattern = '/->where\([^)]*[\x{00C0}-\x{1EF9}][^)]*\)/u';
            
            preg_match_all($pattern, $content, $matches);
            
            $this->assertEmpty(
                $matches[0], 
                "Service [{$file->getRelativePathname()}] chứa chuỗi tiếng Việt raw trong truy vấn where: " . implode(', ', $matches[0])
            );
        }
    }
}
