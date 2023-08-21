import React, { useState, useEffect, useCallback } from "react";
import {
  ResponsiveContainer,
  LineChart,
  Line,
  XAxis,
  YAxis,
  Tooltip,
  Legend,
  CartesianGrid,
} from "recharts";
import { useI18n } from '@wordpress/react-i18n';


const Dropdown = () => {
  const [selectedValue, setSelectedValue] = useState("7days");
  const localizedData = window.graph_widget_data;
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const { __ } = useI18n();
  const fetchData = useCallback(async () => {
    try {
      const response = await fetch(
        `${localizedData.site_url}/wp-json/graph-widget/v1/data?period=${selectedValue}`
      );
      if (!response.ok) {
        throw new Error(__( 'Error fetching data','text-domain' ));
      }
      const data = await response.json();
      setData(data);
      setLoading(false);
      setError(null);
    } catch (error) {
      console.error(error);
      setLoading(false);
      setError(__( 'Error fetching data','text-domain' ));
    }
  }, [
    selectedValue,
    localizedData.site_url,
    __,
  ]);

  useEffect(() => {
    fetchData();
  }, [fetchData]);

  const handleSelectChange = (event) => {
    setSelectedValue(event.target.value);
  };
  return (
    <div className="border border-secondary m-5 p-5">
      <div className="row mb-3">
        <select
          className="form-select form-select-lg"
          value={selectedValue}
          onChange={handleSelectChange}
        >
          <option value="7days">{__( 'Last 7 days','text-domain' )}</option>
          <option value="15days">{__( 'Last 15 days','text-domain' )}</option>
          <option value="1month">{__( 'Last 1 month','text-domain' )}</option>
        </select>
      </div>
      <div className="row">
        {loading ? (
          <div>{__( 'Loading...','text-domain' )}</div>
        ) : error ? (
          <div className="text-danger">{__( 'Error','text-domain' )}: {error}</div>
        ) : data.length === 0 ? (
          <div>{__( 'No data available. Please check again later','text-domain' )}</div>
        ) : (
          <ResponsiveContainer width="100%" aspect={3}>
            <LineChart width={500} height={300} data={data}>
              <XAxis dataKey="name" />
              <YAxis />
              <CartesianGrid stroke="#ccc" />
              <Tooltip contentStyle={{ backgroundColor: "yellow" }} />
              <Legend />
              <Line dataKey="students" name="Students" stroke="red" activeDot={{ r: 2 }} />
              <Line dataKey="fees" name="Fees" stroke="green" activeDot={{ r: 2 }} />
            </LineChart>
          </ResponsiveContainer>
        )}
      </div>
    </div>
  );
};

export default Dropdown;
