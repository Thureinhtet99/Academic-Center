import React, { useState } from "react";
import Navbar from "../../components/navbar/Navbar";
import { useEffect } from "react";
import axios from "axios";
import { Link, useParams } from "react-router-dom";
import {
  Avatar,
  Button,
  Card,
  CardActionArea,
  CardContent,
  CardMedia,
  Typography,
} from "@mui/material";
import FooterComponent from "../../components/footer/FooterComponent";
import { baseApi } from "../../api/BaseApi";

const Instructor = () => {
  // useParams
  const { instructorId } = useParams();

  // useState
  const [progress, setProgress] = useState(false);
  const [author, setAuthor] = useState({});
  const [authorCourseList, setAuthorCourseList] = useState([]);
  const [authorCourseCount, setAuthorCourseCount] = useState("");

  // Author show
  async function authorShow() {
    try {
      const response = await baseApi.post("/author/show", {
        authorId: instructorId,
      });
      setAuthor(response.data.authors);
      setAuthorCourseList(response.data.courses);
      setAuthorCourseCount(response.data.courseCount);
    } catch (error) {
      console.error(error);
    }
  }
  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([authorShow()]).then(() => setProgress(false));
  }, [instructorId]);

  return (
    <>
      <Navbar progress={progress} />

      <main>
        <div className="row px-5">
          <div className="col-12 p-5 d-flex justify-content-start">
            <div className="mx-5">
              {author.author_image === null ? (
                author.author_gender === "male" ? (
                  <Avatar
                    alt=""
                    src={`http://localhost:8000/images/default_user.png`}
                    className=" img-thumbnail"
                    sx={{ width: 200, height: 200 }}
                  />
                ) : (
                  <Avatar
                    alt=""
                    src={`http://localhost:8000/images/default_female.jpg`}
                    className=" img-thumbnail"
                    sx={{ width: 200, height: 200 }}
                  />
                )
              ) : (
                <Avatar
                  alt=""
                  src={author.author_image}
                  className=" img-thumbnail"
                  sx={{ width: 200, height: 200 }}
                />
              )}
            </div>

            <div className="mx-4">
              <div className="d-flex justify-content-between align-items-center">
                <h3 className="text-capitalize m-0">{author.author_name}</h3>

                <Button variant="contained">Contact Now</Button>
              </div>
              <p className="small text-muted">{author.author_degree}</p>
              <h4 className="fw-bold mt-5">
                About (
                <span className="fw-medium small">{author.author_name}</span>)
              </h4>
              <p className="small text-muted">{author.author_about}</p>
            </div>
          </div>
          <hr />
          <div className="col-12 my-3">
            <h5>Total courses - {authorCourseCount}</h5>
            <div className="row my-5">
              {authorCourseList.map((authorCourse) => {
                return (
                  <div
                    className="col-4 px-5 py-4 d-flex justify-content-center align-items-center"
                    key={authorCourse.courseId}
                  >
                    <Link
                      to={`/courses/${authorCourse.courseId}`}
                      className="text-decoration-none text-black"
                    >
                      <Card sx={{ width: 300 }}>
                        <CardActionArea>
                          {authorCourse.course_image === null ? (
                            <CardMedia
                              component="img"
                              height="250"
                              image="http://localhost:8000/images/default-image.png"
                            />
                          ) : (
                            <CardMedia
                              component="img"
                              height="250"
                              image={`http://localhost:8000/storage/${authorCourse.course_image}`}
                            />
                          )}

                          <CardContent>
                            <Typography
                              variant="h5"
                              component="div"
                              className="text-capitalize"
                            >
                              {authorCourse.course_title}
                            </Typography>
                          </CardContent>
                        </CardActionArea>
                      </Card>
                    </Link>
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      </main>

      <footer>
        <FooterComponent />
      </footer>
    </>
  );
};

export default Instructor;
