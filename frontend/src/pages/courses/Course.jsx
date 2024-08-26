import Navbar from "../../components/navbar/Navbar";
import "./course.css";
import TextField from "@mui/material/TextField";
import CourseCardComponent from "../../components/courseCard/CourseCardComponent";
import { useEffect, useState } from "react";
import PaginationComponent from "../../components/PaginationComponent";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import { useLocation } from "react-router-dom";
import LatestCourse from "../../components/latestCourse/LatestCourse";
import CategoryBox from "../../components/categoryBox/CategoryBox";
import TopNavigation from "../../components/topNavigation/TopNavigation";
import FooterComponent from "../../components/footer/FooterComponent";
import SelectComponent from "../../components/SelectComponent";
import { baseApi } from "../../api/BaseApi";

const Course = () => {
  // useState
  const [progress, setProgress] = useState(false);
  const [courseList, setCourseList] = useState([]);
  const [latestCourseList, setLatestCourseList] = useState([]);
  const [sortCourse, setSortCourse] = useState("");

  const [categoryList, setCategoryList] = useState([]);
  const [groupByCategories, setGroupByCategories] = useState([]);
  const [selectedCategory, setSelectedCategory] = useState("");

  const [currentPage, setCurrentPage] = useState(1);
  const [currentItem, setCurrentItem] = useState([]);

  const itemsPerPage = 9;

  // useLocation
  const location = useLocation();

  // Fetch course
  async function fetchCourse() {
    try {
      const courseResponse = await baseApi.get("/courses");
      setCourseList(courseResponse.data.courses);
      setCurrentItem(courseResponse.data.courses.slice(0, itemsPerPage));
      setLatestCourseList(courseResponse.data.latestCourses);
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch category
  async function fetchCategory() {
    try {
      const categoryResponse = await baseApi.get("/categories");
      setCategoryList(categoryResponse.data.categories);
      setGroupByCategories(categoryResponse.data.groupByCategories);
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([fetchCourse(), fetchCategory()]).then(() => {
      setProgress(false);
    });
  }, []);

  const handleSearch = (event) => {
    const filteredCourses = courseList.filter((course) => {
      return course.course_title
        .toLowerCase()
        .includes(event.target.value.toLowerCase());
    });
    setCurrentItem(filteredCourses.slice(0, itemsPerPage));
    setCurrentPage(1);
  };

  const handleCategoryChange = (event) => {
    const categoryId = event.target.value;
    setSelectedCategory(categoryId);
    if (categoryId === "all") {
      setCurrentItem(courseList.slice(0, itemsPerPage));
    } else {
      const filteredCategory = courseList.filter(
        (course) => course.categoryId === categoryId
      );
      setCurrentItem(filteredCategory.slice(0, itemsPerPage));
    }
    setCurrentPage(1);
  };

  const handleSorting = (event) => {
    const sortKey = event.target.value;
    setSortCourse(sortKey);
    const sortedCourse =
      sortKey === "oldest"
        ? [...courseList].sort((a, b) => b.courseId - a.courseId)
        : sortKey === "latest"
        ? [...courseList].sort((a, b) => a.courseId - b.courseId)
        : sortKey === "priceAsc"
        ? [...courseList].sort((a, b) => a.course_price - b.course_price)
        : sortKey === "priceDesc"
        ? [...courseList].sort((a, b) => b.course_price - a.course_price)
        : [...courseList];

    setCurrentItem(sortedCourse.slice(0, itemsPerPage));
    setCurrentPage(1);
  };

  const handlePagination = (event, value) => {
    setCurrentPage(value);
    const indexOfLastItem = value * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    setCurrentItem(courseList.slice(indexOfFirstItem, indexOfLastItem));
  };

  return (
    <>
      <Navbar progress={progress} />

      <main>
        <TopNavigation
          progress={progress}
          location={location.pathname}
          linkName={"courses"}
        />
        <div className="row my-5">
          <div className="col-lg-9 col-md-12 px-4">
            <div className="row mb-5 py-2 d-flex align-items-center rounded courseTopBox">
              <div className="col-xl-4 col-lg-3 col-md-6 py-2">
                <TextField
                  id="outlined-search"
                  label="Search Courses"
                  type="search"
                  size="small"
                  className="bg-white mx-2"
                  onChange={handleSearch}
                />
              </div>
              <div className="col-xl-4 col-lg-3 col-md-6">
                <SelectComponent
                  list={categoryList}
                  selectedItem={selectedCategory}
                  handleChange={handleCategoryChange}
                  label={"Categories"}
                />
              </div>
              <div className="col-xl-4 col-lg-3 col-md-6">
                <FormControl
                  sx={{ m: 1, minWidth: 110 }}
                  size="small"
                  className="bg-white"
                >
                  <InputLabel id="demo-sort-select-label">Sort</InputLabel>
                  <Select
                    labelId="demo-sort-select-label"
                    id="demo-sort-select"
                    label="Sort"
                    margin="dense"
                    className="text-capitalize"
                    value={sortCourse}
                    onChange={handleSorting}
                  >
                    <MenuItem className="text-capitalize" value="oldest">
                      Oldest
                    </MenuItem>
                    <MenuItem className="text-capitalize" value="latest">
                      Latest
                    </MenuItem>
                    <MenuItem className="text-capitalize" value="priceAsc">
                      Price (Ascending)
                    </MenuItem>
                    <MenuItem className="text-capitalize" value="priceDesc">
                      Price (Descending)
                    </MenuItem>
                  </Select>
                </FormControl>
              </div>
            </div>

            <div className="row">
              <div className="col-lg-6 px-3 d-flex justify-content-center justify-content-lg-start justify-content-md-center align-items-center">
                <PaginationComponent
                  list={courseList}
                  itemsPerPage={itemsPerPage}
                  currentPage={currentPage}
                  handlePagination={handlePagination}
                />
              </div>
              <div className="col-lg-6 px-3 text-center text-lg-end text-md-center">
                <small>
                  Showing {itemsPerPage * currentPage} of {courseList.length}{" "}
                  results
                </small>
              </div>
            </div>

            <div className="row mb-5">
              {progress ? (
                <div className="text-center my-5">
                  <div className="spinner-border" role="status">
                    <span className="visually-hidden">Loading...</span>
                  </div>
                </div>
              ) : currentItem.length > 0 ? (
                currentItem.map((course) => (
                  <div
                    className="col-lg-4 col-md-6 my-3 d-flex justify-content-center align-items-center"
                    key={course.courseId}
                  >
                    <CourseCardComponent course={course} width="15" />
                  </div>
                ))
              ) : (
                <div className="col-md-10 offset-md-1 my-3 d-flex justify-content-center align-items-center">
                  <span className="fs-3 text-muted">No courses yet</span>
                </div>
              )}
            </div>
            <div className="row my-5">
              <div className="col-lg-6 px-3 d-flex justify-content-center justify-content-lg-start justify-content-md-center align-items-center">
                <PaginationComponent
                  list={courseList}
                  itemsPerPage={itemsPerPage}
                  currentPage={currentPage}
                  handlePagination={handlePagination}
                />
              </div>
              <div className="col-lg-6 px-3 text-center text-lg-end text-md-center">
                <small>
                  Showing {itemsPerPage * currentPage} of {courseList.length}{" "}
                  results
                </small>
              </div>
            </div>
          </div>
          <div className="col-lg-3 col-md-12 px-4">
            <CategoryBox
              progress={progress}
              groupByCategories={groupByCategories}
            />
            <LatestCourse
              progress={progress}
              latestCourseList={latestCourseList}
            />
          </div>
        </div>
      </main>

      <footer>
        <FooterComponent />
      </footer>
    </>
  );
};

export default Course;
