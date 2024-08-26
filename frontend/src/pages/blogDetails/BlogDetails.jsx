import React, { useEffect, useState } from "react";
import ProgressLoading from "../../components/ProgressLoading";
import Navbar from "../../components/navbar/Navbar";
import TopNavigation from "../../components/topNavigation/TopNavigation";
import { Link, useLocation, useParams } from "react-router-dom";
import { baseApi } from "../../api/BaseApi";
import { styled } from "@mui/material/styles";
import Card from "@mui/material/Card";
import CardHeader from "@mui/material/CardHeader";
import CardMedia from "@mui/material/CardMedia";
import CardContent from "@mui/material/CardContent";
import CardActions from "@mui/material/CardActions";
import Collapse from "@mui/material/Collapse";
import IconButton from "@mui/material/IconButton";
import Typography from "@mui/material/Typography";
import FavoriteIcon from "@mui/icons-material/Favorite";
import ShareIcon from "@mui/icons-material/Share";
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import ProfileAvatar from "../../components/ProfileAvatar";
import dateTimeFormat from "../../context/DateTimeFormat";
import BlogCardComponent from "../../components/blogCard/BlogCardComponent";
import { Chip } from "@mui/material";

const BlogDetails = () => {
  // useState
  const [expanded, setExpanded] = React.useState(false);

  const [progress, setProgress] = useState(false);
  const [blogDetail, setBlogDetail] = useState({});
  const [relatedBlogs, setRelatedBlogs] = useState([]);

  // useLocation
  const location = useLocation();

  // useParams
  const { blogId } = useParams();
  const { instructorId } = useParams();

  // Fetch blog details
  async function fetchBlogDetail() {
    try {
      const response = await baseApi.post("/blog/show", {
        blogId: blogId,
      });
      const relatedBlogsResponse = await baseApi.post(
        "/blog/show/related-blogs",
        {
          relatedBlogCategoryId: response.data.blogDetails.categoryId,
        }
      );
      setBlogDetail(response.data.blogDetails);
      setRelatedBlogs(relatedBlogsResponse.data.relatedBlogs);
    } catch (error) {
      console.error(error);
    }
  }

  // useEffect
  useEffect(() => {
    setProgress(true);
    Promise.all([fetchBlogDetail()]).then(() => setProgress(false));
  }, [blogId]);

  // Expand more
  const ExpandMore = styled((props) => {
    const { expand, ...other } = props;
    return <IconButton {...other} />;
  })(({ theme, expand }) => ({
    transform: !expand ? "rotate(0deg)" : "rotate(180deg)",
    marginLeft: "auto",
    transition: theme.transitions.create("transform", {
      duration: theme.transitions.duration.shortest,
    }),
  }));

  const handleExpandClick = () => {
    setExpanded(!expanded);
  };

  return (
    <>
      {progress && <ProgressLoading />}
      <Navbar />

      <main>
        <TopNavigation
          location={location.pathname}
          progress={progress}
          linkName={"blogs"}
          blogDetail={blogDetail}
        />

        {progress ? (
          <div className="d-flex justify-content-center">
            <div className="spinner-border text-primary my-5" role="status">
              <span className="visually-hidden">Loading...</span>
            </div>
          </div>
        ) : (
          <div className="row">
            <div className="col-lg-10 offset-lg-1 col-sm-12 d-flex flex-column align-items-center">
              <Card sx={{ maxWidth: 700, marginY: "1rem", padding: "0.5rem" }}>
                <CardHeader
                  avatar={
                    <ProfileAvatar
                      photo={blogDetail.author_image}
                      name={blogDetail.author_name}
                      width={50}
                      height={50}
                    />
                  }
                  title={blogDetail.author_name}
                  subheader={dateTimeFormat(blogDetail.blogCreatedAt)}
                />
                <CardContent className="py-0 ">
                  <Chip
                    className="text-capitalize"
                    label={blogDetail.category_name}
                  />
                  <Typography sx={{ marginY: "0.5rem" }} variant="h4">
                    {blogDetail.blog_title}
                  </Typography>
                </CardContent>
                <CardMedia
                  component="img"
                  height="400"
                  image={
                    blogDetail.blog_image
                      ? `http://localhost:8000/storage/${blogDetail.blog_image}`
                      : "http://localhost:8000/images/default-image.png"
                  }
                />
                <CardActions disableSpacing>
                  <IconButton aria-label="add to favorites">
                    <FavoriteIcon />
                  </IconButton>
                  <IconButton aria-label="share">
                    <ShareIcon />
                  </IconButton>
                  <ExpandMore
                    expand={expanded}
                    onClick={handleExpandClick}
                    aria-expanded={expanded}
                    aria-label="show more"
                  >
                    <ExpandMoreIcon />
                  </ExpandMore>
                </CardActions>
                <Collapse in={expanded} timeout="auto" unmountOnExit>
                  <CardContent>
                    {/* <Typography paragraph>Method:</Typography> */}
                    <Typography paragraph>
                      {blogDetail.blog_description}
                    </Typography>
                  </CardContent>
                </Collapse>
              </Card>
              <h3 className="my-3 fw-bold">Related Blogs</h3>
              <div className="row">
                {relatedBlogs.map((relatedBlog) => {
                  return (
                    <div
                      className="col-lg-3 col-md-6 my-3 d-flex justify-content-center align-items-top animate__animated animate__fadeIn"
                      key={relatedBlog.blogId}
                    >
                      <BlogCardComponent
                        blogId={relatedBlog.id}
                        blogImg={relatedBlog.blog_image}
                        blogTitle={relatedBlog.blog_title}
                        categoryName={relatedBlog.category_name}
                        blogDesc={relatedBlog.blog_description}
                        blogCreatedAt={relatedBlog.blogCreatedAt}
                      />
                    </div>
                  );
                })}
              </div>
            </div>
          </div>
        )}
      </main>
    </>
  );
};

export default BlogDetails;
