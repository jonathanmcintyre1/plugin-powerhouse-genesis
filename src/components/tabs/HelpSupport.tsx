
import React from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { CheckCircle2, HelpCircle, Mail } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const HelpSupport: React.FC = () => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <HelpCircle className="h-5 w-5 text-purple-600 mr-2" />
            Quick Start Guide
          </CardTitle>
          <CardDescription>
            Get started with Content Guard in just a few steps
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Accordion type="single" collapsible className="w-full">
            <AccordionItem value="item-1">
              <AccordionTrigger>Getting Started</AccordionTrigger>
              <AccordionContent>
                <ol className="list-decimal pl-5 space-y-2 text-gray-700">
                  <li>Enable the <strong>Content Protection</strong> master switch in General Settings</li>
                  <li>Choose the protection methods you need in each tab (Text, Image, etc.)</li>
                  <li>Configure any notifications or messages you want to display</li>
                  <li>Test your settings on a few pages before enabling site-wide</li>
                </ol>
              </AccordionContent>
            </AccordionItem>
            
            <AccordionItem value="item-2">
              <AccordionTrigger>Recommended Settings</AccordionTrigger>
              <AccordionContent>
                <p className="text-gray-700 mb-3">For most websites, we recommend starting with these settings:</p>
                <ul className="list-disc pl-5 space-y-2 text-gray-700">
                  <li>Enable <strong>Disable Right Click</strong> on both text and images</li>
                  <li>Block the most common keyboard shortcuts (Ctrl+C, Ctrl+S)</li>
                  <li>Enable <strong>Show Tooltip</strong> with a friendly message</li>
                  <li>Use <strong>Disable for Logged-in Users</strong> for a better experience</li>
                </ul>
              </AccordionContent>
            </AccordionItem>
            
            <AccordionItem value="item-3">
              <AccordionTrigger>Troubleshooting</AccordionTrigger>
              <AccordionContent>
                <p className="text-gray-700 mb-3">If you encounter issues:</p>
                <ul className="list-disc pl-5 space-y-2 text-gray-700">
                  <li>Enable <strong>Compatibility Mode</strong> if you experience conflicts</li>
                  <li>Try disabling other JavaScript-heavy plugins temporarily</li>
                  <li>Exclude specific pages that require interaction</li>
                  <li>Update to the latest version of the plugin</li>
                </ul>
              </AccordionContent>
            </AccordionItem>
          </Accordion>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <CheckCircle2 className="h-5 w-5 text-purple-600 mr-2" />
            How to Test Protection
          </CardTitle>
          <CardDescription>
            Verify your protection settings are working correctly
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            <div className="bg-gray-50 p-4 rounded-md border border-gray-200">
              <h3 className="font-medium text-gray-800 mb-2">Text Protection Checklist</h3>
              <div className="space-y-2">
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Try to select text on your website</span>
                </div>
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Right-click on text and check if context menu appears</span>
                </div>
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Try keyboard shortcuts (Ctrl+C after selecting text)</span>
                </div>
              </div>
            </div>
            
            <div className="bg-gray-50 p-4 rounded-md border border-gray-200">
              <h3 className="font-medium text-gray-800 mb-2">Image Protection Checklist</h3>
              <div className="space-y-2">
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Right-click on an image and check if context menu appears</span>
                </div>
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Try to drag an image to your desktop</span>
                </div>
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Check if image path is obscured in browser inspector</span>
                </div>
              </div>
            </div>
            
            <div className="bg-gray-50 p-4 rounded-md border border-gray-200">
              <h3 className="font-medium text-gray-800 mb-2">Advanced Protection Checklist</h3>
              <div className="space-y-2">
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Try to view page source (Ctrl+U)</span>
                </div>
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Attempt to open developer tools (F12)</span>
                </div>
                <div className="flex items-start">
                  <div className="h-5 w-5 flex items-center justify-center mt-0.5">
                    <input type="checkbox" className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500" />
                  </div>
                  <span className="ml-2 text-gray-700 text-sm">Check if notifications appear when protection is triggered</span>
                </div>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle className="flex items-center">
            <Mail className="h-5 w-5 text-purple-600 mr-2" />
            Contact Support
          </CardTitle>
          <CardDescription>
            Need help? Send us a message and we'll get back to you
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form className="space-y-4">
            <div>
              <Label htmlFor="email">Your Email</Label>
              <Input id="email" placeholder="your@email.com" className="mt-1" />
            </div>
            <div>
              <Label htmlFor="subject">Subject</Label>
              <Input id="subject" placeholder="Support Request" className="mt-1" />
            </div>
            <div>
              <Label htmlFor="message">Message</Label>
              <Textarea
                id="message"
                placeholder="Describe your issue in detail..."
                className="mt-1"
                rows={5}
              />
            </div>
            <div className="flex items-center space-x-2">
              <Button className="bg-purple-600 hover:bg-purple-700">Send Message</Button>
              <Button variant="outline">Check Documentation</Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  );
};

export default HelpSupport;
