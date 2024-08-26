import { useEffect, useState } from "react";
import Navbar from "../../components/navbar/Navbar";
import "./home.css";
import CourseCardComponent from "../../components/courseCard/CourseCardComponent";
import { Link } from "react-router-dom";
import {
  Button,
  Card,
  CardActionArea,
  CardActions,
  CardContent,
  CardMedia,
  Typography,
} from "@mui/material";
import FooterComponent from "../../components/footer/FooterComponent";
import KeyboardDoubleArrowRightIcon from "@mui/icons-material/KeyboardDoubleArrowRight";
import Skeleton from "@mui/material/Skeleton";
import { baseApi } from "../../api/BaseApi";
import dateTimeFormat from "../../context/DateTimeFormat";
import ReactTimeAgo from "react-time-ago";

const CarouselSection = ({ progress, carouselLists }) => {
  return (
    <>
      <div className="row">
        <div className="col-12 p-0">
          <div id="carouselExampleCaptions" className="carousel slide">
            <div className="carousel-indicators">
              {carouselLists.map((slide, index) => {
                return (
                  <button
                    type="button"
                    data-bs-target="#carouselExampleCaptions"
                    data-bs-slide-to={index}
                    className={index === 0 ? "active" : ""}
                    aria-current={index === 0 ? "true" : "false"}
                    key={index}
                  />
                );
              })}
            </div>
            <div className="carousel-inner">
              {carouselLists.map((carouselList, index) => {
                return (
                  <div
                    className={`carousel-item ${index === 0 ? "active" : ""} `}
                    key={carouselList.id}
                  >
                    {progress ? (
                      <Skeleton
                        variant="rectangular"
                        style={{ height: "38rem" }}
                      />
                    ) : (
                      <img
                        src={`http://localhost:8000/storage/${carouselList.carousel_image}`}
                        className="d-block w-100 object-fit-cover"
                        alt=""
                        style={{ height: "36rem" }}
                      />
                    )}

                    <div className="carousel-caption d-none d-md-block">
                      <h4 className="text-capitalize">
                        {carouselList.carousel_description}
                      </h4>
                    </div>
                  </div>
                );
              })}
            </div>
            <button
              className="carousel-control-prev"
              type="button"
              data-bs-target="#carouselExampleCaptions"
              data-bs-slide="prev"
            >
              <span className="carousel-control-prev-icon" aria-hidden="true" />
              <span className="visually-hidden">Previous</span>
            </button>
            <button
              className="carousel-control-next"
              type="button"
              data-bs-target="#carouselExampleCaptions"
              data-bs-slide="next"
            >
              <span className="carousel-control-next-icon" aria-hidden="true" />
              <span className="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </>
  );
};

const WelcomeSection = () => {
  const welcomeCards = [
    { id: 1, name: "best courses", text: "Lorem ipsum dolor sit amet" },
    { id: 2, name: "blogs", text: "Lorem ipsum dolor sit amet" },
    { id: 3, name: "expert instructors", text: "Lorem ipsum dolor sit amet" },
    { id: 4, name: "video lessons", text: "Lorem ipsum dolor sit amet" },
  ];

  return (
    <>
      <div className="row py-5 popularCourseSection">
        <div className="col-md-12 text-center">
          <h1 className="fw-bold">Welcome To Academic Center</h1>
          <p className="col-md-8 offset-md-2 text-muted small">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium
            sed reprehenderit odio. Cumque magnam libero nemo.
          </p>
        </div>
      </div>
      <div className="row pb-5 popularCourseSection">
        {welcomeCards.map((card) => {
          return (
            <div
              className="col-lg-3 col-md-6 my-3 d-flex justify-content-center"
              key={card.id}
            >
              <div className="card p-4 border-0" style={{ width: "18rem" }}>
                <div className="py-3 text-center">
                  <i className="fa-solid fa-book fs-1"></i>
                </div>
                <div className="card-body">
                  <h4 className="card-title text-center fw-bold text-capitalize">
                    {card.name}
                  </h4>
                  <p className="small card-text text-center text-muted">
                    {card.text}
                  </p>
                </div>
              </div>
            </div>
          );
        })}
      </div>
    </>
  );
};

const PopularCourseSection = ({ popularCourseList }) => {
  return (
    <>
      <div className="row py-5">
        <div className="col-md-12 px-5 text-center ">
          <h1 className="fw-bold">Popular Courses</h1>
          {popularCourseList ? (
            <p className="col-md-8 offset-md-2 text-muted small">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Laudantium sed reprehenderit odio. Cumque magnam libero nemo.
            </p>
          ) : (
            ""
          )}
        </div>
      </div>

      <div className="row pb-5 px-3">
        {popularCourseList.map((popularCourse) => {
          return (
            <div
              className="col-xl-4 col-md-6 my-2 d-flex justify-content-center align-items-center"
              key={popularCourse.courseId}
            >
              <CourseCardComponent course={popularCourse} width="23" />
            </div>
          );
        })}
        <div className="col-md-12 mt-5 text-center">
          <Link to="/courses">
            <Button variant="contained" className="ms-3 py-2 px-4 bg-primary">
              View All Courses
            </Button>
          </Link>
        </div>
      </div>
    </>
  );
};

const InstructorSection = ({ authorList }) => {
  return (
    <>
      <div className="row py-5 popularCourseSection">
        <div className="col-md-12 text-center">
          <h1 className="fw-bold">Instructors</h1>
          <p className="col-md-8 offset-md-2 text-muted small">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium
            sed reprehenderit odio. Cumque magnam libero nemo.
          </p>
        </div>
      </div>

      <div className="row pb-5 py-4 px-3 popularCourseSection">
        {authorList.map((author) => {
          return (
            <div
              className="col-xl-3 col-lg-3 col-md-6 d-flex justify-content-center align-items-center my-5 position-relative"
              key={author.id}
            >
              <Link
                to={`/instructor/${author.id} `}
                className="text-decoration-none"
              >
                <div className="card border" style={{ width: "17rem" }}>
                  <div className="card-body mt-5 py-5 px-3">
                    <img
                      src={
                        author.author_image === null
                          ? author.author_gender === "male"
                            ? "http://localhost:8000/images/default_user.png"
                            : "http://localhost:8000/images/default_female.jpg"
                          : `http://localhost:8000/storage/${author.author_image}`
                      }
                      alt=""
                      className="position-absolute top-0 start-50 translate-middle border rounded authorImg"
                      style={{
                        width: "11rem",
                        height: "10rem",
                        marginTop: "-0.1rem",
                      }}
                    />
                    <h5 className="card-title text-center fw-bold text-capitalize">
                      {author.author_name}
                    </h5>
                    <p className="card-text text-muted text-center">
                      {author.author_degree}
                    </p>
                  </div>
                </div>
              </Link>
            </div>
          );
        })}
      </div>
    </>
  );
};

const BlogSection = ({ mostTrendBlogs, trendBlogs }) => {
  return (
    <>
      <div className="row my-5">
        <div className="col-md-12 text-center">
          <h1 className="fw-bold">Trend Blogs</h1>
          <p className="col-md-8 offset-md-2 text-muted small">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium
            sed reprehenderit odio. Cumque magnam libero nemo.
          </p>
        </div>
      </div>

      <div className="row mb-5">
        <div className="col-lg-6 px-4 ">
          <Card>
            <CardActionArea>
              {mostTrendBlogs.blog_image && (
                <CardMedia
                  component="img"
                  height="300"
                  image={`http://localhost:8000/storage/${mostTrendBlogs.blog_image}`}
                />
              )}

              <CardContent>
                <Typography
                  gutterBottom
                  variant="h5"
                  component="div"
                  className="fw-bold text-capitalize"
                >
                  {mostTrendBlogs.blog_title}
                </Typography>
                <Typography className="text-muted mb-2">
                  <small>
                    {mostTrendBlogs.blogCreatedAt &&
                      dateTimeFormat(mostTrendBlogs.blogCreatedAt)}
                  </small>
                </Typography>
                <Typography variant="body2" color="text">
                  {mostTrendBlogs.blog_description &&
                  mostTrendBlogs.blog_description.length > 301
                    ? mostTrendBlogs.blog_description.slice(0, 300) + "....."
                    : mostTrendBlogs.blog_description}
                </Typography>
              </CardContent>
            </CardActionArea>
            <CardActions>
              <Button
                size="small"
                endIcon={<KeyboardDoubleArrowRightIcon />}
                className="text-black"
              >
                <Link
                  to={`/blog/${mostTrendBlogs.blogId}`}
                  className=" text-black blogLink"
                >
                  read more
                </Link>
              </Button>
            </CardActions>
          </Card>
        </div>
        <div className="col-lg-6 px-4 d-flex flex-column justify-content-between">
          {trendBlogs.map((trendBlog) => {
            return (
              <div className="row mb-4" key={trendBlog.blogId}>
                <div className="col-12">
                  <Link
                    to={`/blog/${trendBlog.blogId}`}
                    className="text-decoration-none"
                  >
                    <Card className="w-100">
                      <CardActionArea>
                        <CardContent>
                          <Typography
                            gutterBottom
                            variant="h6"
                            component="div"
                            className="fw-bold text-capitalize"
                          >
                            {trendBlog.blog_title}
                          </Typography>
                          <Typography className="text-muted mb-2">
                            <small>
                              {dateTimeFormat(trendBlog.blogCreatedAt)}
                            </small>
                          </Typography>

                          <Typography variant="body2" color="text">
                            {trendBlog.blog_description &&
                            trendBlog.blog_description.length > 81
                              ? trendBlog.blog_description.slice(0, 80) +
                                "....."
                              : trendBlog.blog_description}
                          </Typography>
                        </CardContent>
                      </CardActionArea>
                    </Card>
                  </Link>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </>
  );
};

const Home = () => {
  // useState
  const [progress, setProgress] = useState(false);

  const [carouselLists, setCarouselLists] = useState([]);
  const [popularCourseList, setPopularCourseList] = useState([]);
  const [authorList, setAuthorList] = useState([]);
  const [mostTrendBlogs, setMostTrendBlogs] = useState([]);
  const [trendBlogs, setTrendBlogs] = useState([]);

  // Fetch carousel
  async function fetchCarousel() {
    try {
      const response = await baseApi.get("/carousels");
      setCarouselLists(response.data);
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch popular courses
  async function fetchPopularCourse() {
    try {
      const response = await baseApi.get("/action-logs");
      setPopularCourseList(response.data.actionLogs.slice(0, 3));
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch authors
  async function fetchAuthor() {
    try {
      const response = await baseApi.get("/authors");
      setAuthorList(response.data.slice(0, 4));
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch blog action-logs
  async function fetchBlogActionLog() {
    try {
      const response = await baseApi.get("/blog-action-logs");
      setTrendBlogs(response.data.trendBlogs);
      setMostTrendBlogs(response.data.mostTrendBlogs);
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([
      fetchCarousel(),
      fetchPopularCourse(),
      fetchAuthor(),
      fetchBlogActionLog(),
    ]).then(() => setProgress(false));
  }, []);

  return (
    <>
      <Navbar progress={progress} />

      <main>
        <CarouselSection progress={progress} carouselLists={carouselLists} />

        <WelcomeSection />

        <PopularCourseSection popularCourseList={popularCourseList} />

        <InstructorSection authorList={authorList} />

        <BlogSection mostTrendBlogs={mostTrendBlogs} trendBlogs={trendBlogs} />
      </main>

      <footer>
        <FooterComponent />
      </footer>
    </>
  );
};

export default Home;
