import 'bootstrap/dist/css/bootstrap.min.css';
import { Container, Col, Row, ListGroup, ListGroupItem } from 'react-bootstrap';
import { useEffect, useState } from 'react';
import axios from 'axios';
import './App.css';

function App() {
  const apiurl = "http://127.0.0.1:8000/api/";
  const [category, setCategory] = useState([]);
  const [selectCategory, setSelectCategory] = useState(null);

  const [subCategory, setSubCategory] = useState([]);
  const [selectSubCategory, setSelectSubCategory] = useState(null);

  const [pdfs, setPdfs] = useState([]);
  useEffect(() => {
    fetchCategories()
  }, [])

  useEffect(() => {
    if (selectCategory) {
      fetchSubCategories();
    }
  }, [selectCategory]);

  useEffect(() => {
    if (selectSubCategory) {
      fetchPdf();
    }
  }, [selectSubCategory]);

  const fetchCategories = async () => {
    try {

      await axios.get(apiurl + 'get-categories')
        .then((res) => {
          if (res.data.success) {
            let data = res.data.data;
            setCategory(data);
            if (data[0] && data[0]['id']) {
              setSelectCategory(data[0]['id']);
            }
          }
          else {
            console.log('Products not found.');
          }
        })
        .catch(error => {
          console.log('error', error)
        });
    }
    catch (error) {
      console.error('Error creating item:', error);
    }
  }

  const fetchSubCategories = async () => {
    try {

      await axios.get(apiurl + 'subcategories/' + selectCategory)
        .then((res) => {
          if (res.data.success) {
            let data = res.data.data;
            setSubCategory(data);
            if (data.length > 0 && data[0]['id']) {
              setSelectSubCategory(data[0]['id'])
            }else{
              fetchPdf();
            }
          }
          else {
            console.log('Products not found.');
          }
        })
        .catch(error => {
          console.log('error', error)
        });
    }
    catch (error) {
      console.error('Error creating item:', error);
    }
  }

  const fetchPdf = async () => {
    try {
      let makeUrl = apiurl + 'getpdfs/' + selectCategory;
      if (selectSubCategory) {
        makeUrl += '/' + selectSubCategory;
      }
      await axios.get(makeUrl)
        .then((res) => {
          if (res.data.success) {
            let data = res.data.data;
            // console.log("pdg", data);
            setPdfs(data);
          }
          else {
            console.log('Products not found.');
          }
        })
        .catch(error => {
          console.log('error', error)
        });
    }
    catch (error) {
      console.error('Error creating item:', error);
    }
  }

  return (
    <>
      <Container>
        <Row>
          <Col md={3}>
            <ListGroup >
              {
                category.length > 0 && category.map((record, index) => {
                  return (<ListGroupItem key={record.id} className='categoryItem' onClick={() => setSelectCategory(record.id)}>
                    <div>
                      <img src={record.icon_url} className='categoryItemImage' />
                      {record.name}
                    </div>
                  </ListGroupItem>)
                })
              }
            </ListGroup>
          </Col>
          <Col className='ml-5'>
            <div className='d-flex'>
              <h2 className='ms-auto titelFinancialRresults'>FINANCIAL RESULTS</h2>
            </div>
            <div className='d-flex'>
              {
                subCategory.length > 0 && subCategory.map((record, index) => {
                  return (
                    <div className='subcategoryBox' key={'subcategory' + index} onClick={() => setSelectSubCategory(record.id)}>{record.name}</div>
                  )
                })
              }
            </div>

            {
              pdfs.length > 0 ? pdfs.map((record, index) => {
                return (
                  <Row className='mt-2 mb-2'>
                    <Col>
                      <img src="https://www.svgrepo.com/show/66745/pdf.svg" width={"50px"} />
                      {
                        (record.sub_category_name ? record.sub_category_name : record.category_name)+'.pdf' 
                      }
                    </Col>
                  </Row>
                )
              })
                : <div>NO Data Found</div>
            }
            <Row>
            </Row>
          </Col>
        </Row>
      </Container>
    </>
  );
}

export default App;
