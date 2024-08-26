import { useState, useEffect } from "react";
import ProgressLoading from "../../components/ProgressLoading";
import Navbar from "../../components/navbar/Navbar";
import TopNavigation from "../../components/topNavigation/TopNavigation";
import { useLocation } from "react-router-dom";
import BlogCardComponent from "../../components/blogCard/BlogCardComponent";
import { baseApi } from "../../api/BaseApi";
import PaginationComponent from "../../components/PaginationComponent";

export default function Blog() {
  // useState
  const [progress, setProgress] = useState(false);

  const [blogList, setBlogList] = useState([]);

  const [categories, setCategories] = useState([]);
  const [selectedCategory, setSelectedCategory] = useState("all");

  const [currentPage, setCurrentPage] = useState(1);
  const [currentItem, setCurrentItem] = useState([]);

  const itemsPerPage = 12;

  // useLocation
  const location = useLocation();

  // Fetch blogs
  async function fetchBlogs() {
    try {
      const response = await baseApi.get("/blogs");
      setBlogList(response.data.blogs);
      setCurrentItem(response.data.blogs.slice(0, itemsPerPage));
      setCategories(response.data.categories);
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([fetchBlogs()]).then(() => setProgress(false));
  }, []);

  // Handle category filter
  function handleCategoryFilter(event) {
    const categoryId = event.target.value;
    setSelectedCategory(categoryId);
    if (categoryId === "all") {
      setCurrentItem(blogList.slice(0, itemsPerPage));
    } else {
      const filteredCategory = blogList.filter(
        (blog) => blog.categoryId === categoryId
      );
      setCurrentItem(filteredCategory.slice(0, itemsPerPage));
    }
    setCurrentPage(1);
  }

  // Handle search blogs
  function handleSearchBlogs(event) {
    const filteredBlogs = blogList.filter((blog) => {
      return blog.blog_title
        .toLowerCase()
        .includes(event.target.value.toLowerCase());
    });
    setCurrentItem(filteredBlogs.slice(0, itemsPerPage));
    setCurrentPage(1);
  }

  // Handle pagination
  function handlePagination(event, value) {
    setCurrentPage(value);
    const indexOfLastItem = value * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    setCurrentItem(blogList.slice(indexOfFirstItem, indexOfLastItem));
  }

  return (
    <>
      {progress && <ProgressLoading />}
      <Navbar />

      <main>
        <TopNavigation location={location.pathname} linkName={"blogs"} />

        <div className="row mx-0 my-5 px-5">
          <div className="col-12">
            <h1 className="text-center fw-bold">Blogs</h1>
            <form action="">
              <div className="d-flex justify-content-center align-items-center my-5">
                <select
                  className="form-select text-capitalize"
                  style={{ width: "10rem" }}
                  value={selectedCategory}
                  onChange={handleCategoryFilter}
                >
                  <option value="all" className="fw-bold">
                    All
                  </option>
                  {categories.map((category) => (
                    <option
                      value={category.category_name}
                      key={category.id}
                      className="text-capitalize"
                    >
                      {category.category_name}
                    </option>
                  ))}
                </select>
                <input
                  type="search"
                  className="form-control mx-2"
                  placeholder="Search blogs....."
                  onChange={handleSearchBlogs}
                  style={{ width: "45rem" }}
                />
              </div>
            </form>
          </div>
          {progress ? (
            <div className="d-flex justify-content-center">
              <div className="spinner-border text-primary my-5" role="status">
                <span className="visually-hidden">Loading...</span>
              </div>
            </div>
          ) : currentItem.length > 0 ? (
            currentItem.map((blog) => (
              <div
                className="col-lg-3 col-md-6 my-3 d-flex justify-content-center align-items-center animate__animated animate__fadeIn"
                key={blog.blogId}
              >
                <BlogCardComponent
                  blogId={blog.blogId}
                  blogImg={blog.blog_image}
                  blogTitle={blog.blog_title}
                  categoryName={blog.category_name}
                  blogDesc={blog.blog_description}
                  blogCreatedAt={blog.blogCreatedAt}
                />
              </div>
            ))
          ) : (
            <div className="col-md-10 offset-md-1 my-3 d-flex justify-content-center align-items-center">
              <span className="fs-3 text-muted">No blogs yet</span>
            </div>
          )}
        </div>
        <div className="row my-5">
          <div className="col-lg-6 px-3 d-flex justify-content-center justify-content-lg-start justify-content-md-center align-items-center">
            <PaginationComponent
              list={blogList}
              itemsPerPage={itemsPerPage}
              currentPage={currentPage}
              handlePagination={handlePagination}
            />
          </div>
          <div className="col-lg-6 px-3 text-center text-lg-end text-md-center">
            <small>
              Showing {itemsPerPage * currentPage} of {blogList.length} results
            </small>
          </div>
        </div>
      </main>
    </>
  );
}
