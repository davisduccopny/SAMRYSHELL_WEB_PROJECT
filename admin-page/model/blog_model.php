<?php
class BlogModel {
    private $conn;
   
    public function __construct($conn) {
        $this->conn = $conn;
    }
    private function createSlug($str, $delimiter = '-') {
        $chars = array(
            'a' => 'áàảãạăắằẳẵặâấầẩẫậ',
            'd' => 'đ',
            'e' => 'éèẻẽẹêếềểễệ',
            'i' => 'íìỉĩị',
            'o' => 'óòỏõọôốồổỗộơớờởỡợ',
            'u' => 'úùủũụưứừửữự',
            'y' => 'ýỳỷỹỵ',
        );
        $str = mb_strtolower($str, 'UTF-8');
        $str = preg_replace('/[^a-z0-9' . implode('', $chars) . ']+/u', ' ', $str);
        foreach ($chars as $replacement => $pattern) {
            $str = preg_replace("/[$pattern]/u", $replacement, $str);
        }
        $str = preg_replace('/\s+/', ' ', $str);
        $str = str_replace(' ', $delimiter, $str);
        $str = trim($str, '-');
        return $str;
    }

    public function insertBlog($name, $description, $content, $created_by,$category_id, $image, $imagetmp) {
        $location = "../upload/blog" ;
        $imageinsert = $location . $image;
    
        $target_dir = "../upload/blog" ;
         if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $finalImage = $target_dir . $image;
    
        move_uploaded_file($imagetmp, $finalImage);
        // Tạo truy vấn INSERT
        
        $query = "INSERT INTO blog (title, description,content, created_by, category_id,image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssis", $name, $description, $content,$created_by,$category_id, $imageinsert);

        // Thực hiện truy vấn
        return $stmt->execute();
    }

    public function updateBlog($blog_id,$name, $description, $content, $created_by,$category_id, $image, $imagetmp) {
        $category_link = $this->createSlug($name);
        if (isset($image) && $image != null) {
        $location = "../upload/blog";
        $imageinsert = $location . $image;
        $target_dir = "../upload/blog";
         if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $finalImage = $target_dir . $image;
        move_uploaded_file($imagetmp, $finalImage);
        $query = "UPDATE blog SET title=?, description=?, content=?,created_by=?,category_id=?,image=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssisi", $name, $description,$content,$created_by,$category_id,$imageinsert,$blog_id);
        return $stmt->execute();
        }else{
            $query = "UPDATE blog SET title=?, description=?, content=?,created_by=?,category_id=? WHERE id=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssi", $name, $description,$content,$created_by,$category_id,$blog_id);
            return $stmt->execute();
        }
            
        }

    public function deleteBlog($blog_id) {
        // Tạo truy vấn DELETE
        $query = "DELETE FROM blog WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $blog_id);
        // Thực hiện truy vấn
        return $stmt->execute();
    }

    public function getBlog($blog_id) {
        // Khai báo biến
        $name = $category_id = $content = $description = $created_by = $image =null;

        // Tạo truy vấn SELECT
        $query = "SELECT id, title, description, content,image, created_by,category_id FROM blog WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $blog_id);
        
        // Thực hiện truy vấn
        $stmt->execute();
        
        // Ràng buộc kết quả trả về cho các cột
        $stmt->bind_result($blog_id, $name, $description, $content, $image, $created_by,$category_id);
        
        // Lấy dòng kết quả
        $stmt->fetch();
        
        // Trả về kết quả dưới dạng mảng
        return [
            'blog_id' => $blog_id,
            'name' => $name,
            'description' => $description,
            'content' => $content,
            'image' => $image,
            'created_by' => $created_by,
            'category_id' => $category_id
        ];
    }
    
    public function showBlog() {
        $id= $name = $content = $category_id =$description= $created_by= $image = $category_name = null;
        // Tạo truy vấn SELECT
        $query = "SELECT b.id, b.title, b.description, b.content,b.image,b.created_by,b.category_id,c.name FROM blog b
        JOIN category_blog c ON c.id = b.category_id";
        $stmt = $this->conn->prepare($query);
        
        // Thực hiện truy vấn
        $stmt->execute();
        
        // Ràng buộc kết quả trả về cho các cột
        $stmt->bind_result($id, $name, $description, $content,$image,$created_by,$category_id,$category_name);
        
        // Tạo mảng để lưu trữ tất cả các dòng kết quả
        $results = [];
        
        // Lặp qua các dòng và lấy dữ liệu
        while ($stmt->fetch()) {
            $results[] = [
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'content' => $content,
                'image' => $image,
                'created_by' => $created_by,
                'category_id' => $category_id,
                'category_name'=> $category_name
            ];
        }
        
        // Trả về mảng chứa tất cả các dòng kết quả
        return $results;
    }
    public function showCategory_blog() {
        $id= $name = null;
        // Tạo truy vấn SELECT
        $query = "SELECT id, name FROM category_blog";
        $stmt = $this->conn->prepare($query);
        
        // Thực hiện truy vấn
        $stmt->execute();
        
        // Ràng buộc kết quả trả về cho các cột
        $stmt->bind_result($id, $name);
        
        // Tạo mảng để lưu trữ tất cả các dòng kết quả
        $results = [];
        
        // Lặp qua các dòng và lấy dữ liệu
        while ($stmt->fetch()) {
            $results[] = [
                'id' => $id,
                'name' => $name
            ];
        }
        
        // Trả về mảng chứa tất cả các dòng kết quả
        return $results;
    }
}
?>
